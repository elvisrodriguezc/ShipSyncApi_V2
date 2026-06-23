<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of all menus.
     */
    public function index()
    {
        $menus = Menu::with(['parent'])->orderBy('order')->get();
        return response()->json([
            'data' => $menus,
            'meta' => [
                'total' => $menus->count()
            ]
        ]);
    }

    /**
     * Store a newly created menu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:menus,slug',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'integer',
            'active' => 'boolean'
        ]);

        $menu = Menu::create($request->all());

        return response()->json([
            'message' => 'Menú creado correctamente',
            'data' => $menu,
            'error' => 0
        ]);
    }

    /**
     * Display the specified menu.
     */
    public function show($id)
    {
        $menu = Menu::with(['parent', 'roles'])->findOrFail($id);
        return response()->json(['data' => $menu]);
    }

    /**
     * Update the specified menu.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:menus,slug,' . $id,
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'integer',
            'active' => 'boolean'
        ]);

        $menu->update($request->all());

        return response()->json([
            'message' => 'Menú actualizado correctamente',
            'data' => $menu,
            'error' => 0
        ]);
    }

    /**
     * Remove the specified menu.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json([
            'message' => 'Menú eliminado correctamente',
            'error' => 0
        ]);
    }

    /**
     * Get the dynamic menu tree of the authenticated user.
     */
    public function userMenu(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Get all role IDs for the user (including single role_id for backward compatibility)
        $roleIds = $user->roles()->pluck('roles.id')->toArray();
        if ($user->role_id) {
            $roleIds[] = $user->role_id;
        }
        $roleIds = array_unique($roleIds);

        // Fetch menus linked to these roles
        $menus = Menu::where('active', true)
            ->whereHas('roles', function ($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            })
            ->with(['roles' => function ($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            }])
            ->get();

        // Resolve order based on roles' pivot orders
        $menus = $menus->map(function ($menu) {
            $minOrder = $menu->roles->min('pivot.order') ?? $menu->order;
            $menu->resolved_order = $minOrder;
            return $menu;
        })->sortBy('resolved_order')->values();

        // Build hierarchical tree
        $menuTree = [];
        $menuMap = [];

        foreach ($menus as $menu) {
            $menuMap[$menu->id] = [
                'id' => $menu->id,
                'parent_id' => $menu->parent_id,
                'name' => $menu->name,
                'slug' => $menu->slug,
                'icon' => $menu->icon,
                'route' => $menu->route,
                'order' => $menu->resolved_order,
                'children' => []
            ];
        }

        foreach ($menuMap as $id => &$menuNode) {
            if ($menuNode['parent_id'] === null) {
                $menuTree[] = &$menuNode;
            } else {
                if (isset($menuMap[$menuNode['parent_id']])) {
                    $menuMap[$menuNode['parent_id']]['children'][] = &$menuNode;
                } else {
                    // Fallback to top-level if parent is inactive/unavailable
                    $menuTree[] = &$menuNode;
                }
            }
        }
        unset($menuNode);

        // Recursive sorting
        $sortChildren = function (&$tree) use (&$sortChildren) {
            usort($tree, function ($a, $b) {
                return $a['order'] <=> $b['order'];
            });
            foreach ($tree as &$node) {
                if (!empty($node['children'])) {
                    $sortChildren($node['children']);
                }
            }
        };

        $sortChildren($menuTree);

        return response()->json([
            'data' => $menuTree
        ]);
    }

    /**
     * Assign menus to a specific role.
     */
    public function assignMenusToRole(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $request->validate([
            'menus' => 'required|array',
            'menus.*.menu_id' => 'required|exists:menus,id',
            'menus.*.order' => 'integer'
        ]);

        $syncData = [];
        foreach ($request->input('menus') as $item) {
            $syncData[$item['menu_id']] = ['order' => $item['order'] ?? 0];
        }

        DB::transaction(function () use ($role, $syncData) {
            $role->menus()->sync($syncData);
        });

        return response()->json([
            'message' => 'Menús asignados al rol correctamente',
            'error' => 0
        ]);
    }

    /**
     * Get menus assigned to a specific role.
     */
    public function getRoleMenus($roleId)
    {
        $role = Role::with('menus')->findOrFail($roleId);
        return response()->json([
            'data' => $role->menus
        ]);
    }
}
