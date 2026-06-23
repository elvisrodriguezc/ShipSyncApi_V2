<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create or Find Roles
        $sadmin = Role::firstOrCreate(['slug' => 'sadmin'], [
            'company_id' => 1,
            'name' => 'Super Administrator',
            'description' => 'Super Administrator with full access',
            'status' => 1
        ]);

        $pfadmin = Role::firstOrCreate(['slug' => 'pfadmin'], [
            'company_id' => 1,
            'name' => 'PuntoFresh Admin',
            'description' => 'PuntoFresh Administrator',
            'status' => 1
        ]);

        $pfproducer = Role::firstOrCreate(['slug' => 'pfproducer'], [
            'company_id' => 1,
            'name' => 'PuntoFresh Producer',
            'description' => 'PuntoFresh Producer',
            'status' => 1
        ]);

        $userRole = Role::firstOrCreate(['slug' => 'user'], [
            'company_id' => 1,
            'name' => 'User',
            'description' => 'Standard User',
            'status' => 1
        ]);

        // Attach user 'elvisrodriguezc' to 'sadmin' role for M:N roles testing
        $user = User::where('username', 'elvisrodriguezc')->first();
        if ($user) {
            $user->roles()->syncWithoutDetaching([$sadmin->id]);
        }

        // 2. Create Menus

        $menusList = [
            // Dashboard
            [
                'name' => 'Panel Informativo',
                'slug' => 'panel-informativo',
                'icon' => 'fa fa-sitemap',
                'route' => '/dashboard',
                'order' => 10,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Users
            [
                'name' => 'Usuarios',
                'slug' => 'usuarios',
                'icon' => 'fa fa-users',
                'route' => '/users/users',
                'order' => 20,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            [
                'name' => 'Roles y Permisos',
                'slug' => 'roles-permisos',
                'icon' => 'fa fa-lock',
                'route' => '/users/roles',
                'order' => 30,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Contactos
            [
                'name' => 'Contactos',
                'slug' => 'contactos',
                'icon' => 'fa fa-users',
                'route' => '/contacts/contacts',
                'order' => 40,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Reportes Parent
            [
                'name' => 'Reportes',
                'slug' => 'reportes',
                'icon' => 'fa fa-chart-bar',
                'route' => '/reports',
                'order' => 50,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            [
                'name' => 'Stock de Productos',
                'slug' => 'stock-productos',
                'icon' => null,
                'route' => '/reports/stock',
                'order' => 51,
                'parent_slug' => 'reportes',
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Lotes
            [
                'name' => 'Lotes',
                'slug' => 'lotes',
                'icon' => 'fa fa-layer-group',
                'route' => '/batches/batches',
                'order' => 60,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Movimientos Inventario
            [
                'name' => 'Mov. Inventario',
                'slug' => 'movimientos-inventario',
                'icon' => 'fa fa-book',
                'route' => '/movimientos-inventario/movimientos-inventario',
                'order' => 70,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Productos
            [
                'name' => 'Productos',
                'slug' => 'productos',
                'icon' => 'fa fa-cubes',
                'route' => '/products/products',
                'order' => 80,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Categorías
            [
                'name' => 'Categorías',
                'slug' => 'categorias',
                'icon' => 'fa fa-tags',
                'route' => '/categories/categories',
                'order' => 90,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Proveedores
            [
                'name' => 'Proveedores',
                'slug' => 'proveedores',
                'icon' => 'fa fa-truck',
                'route' => '/proveedores/proveedores',
                'order' => 100,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Compras
            [
                'name' => 'Compras',
                'slug' => 'compras',
                'icon' => 'fa fa-shopping-cart',
                'route' => '/purchases/purchases',
                'order' => 110,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Pedidos
            [
                'name' => 'Pedidos',
                'slug' => 'pedidos',
                'icon' => 'fa fa-shopping-bag',
                'route' => '/orders/orders',
                'order' => 115,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin', 'pfproducer', 'user']
            ],
            // Almacén Parent
            [
                'name' => 'Almacén',
                'slug' => 'almacen',
                'icon' => 'fa fa-warehouse',
                'route' => '/warehouse',
                'order' => 120,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin']
            ],
            [
                'name' => 'Sucursales',
                'slug' => 'sucursales',
                'icon' => null,
                'route' => '/warehouse/headquarters',
                'order' => 121,
                'parent_slug' => 'almacen',
                'roles' => ['sadmin', 'pfadmin']
            ],
            [
                'name' => 'Almacenes',
                'slug' => 'almacenes',
                'icon' => null,
                'route' => '/warehouse/warehouses',
                'order' => 122,
                'parent_slug' => 'almacen',
                'roles' => ['sadmin', 'pfadmin']
            ],
            // Ordenes de Producción Parent
            [
                'name' => 'Orden de Producción',
                'slug' => 'orden-produccion',
                'icon' => 'fa fa-file',
                'route' => '/orderform',
                'order' => 130,
                'parent_slug' => null,
                'roles' => ['sadmin', 'pfadmin', 'pfproducer']
            ],
            [
                'name' => 'Ordenes de Producción',
                'slug' => 'ordenes-produccion-hijo',
                'icon' => null,
                'route' => '/orderform/productionorders',
                'order' => 131,
                'parent_slug' => 'orden-produccion',
                'roles' => ['sadmin', 'pfadmin']
            ],
            [
                'name' => 'Ordenes',
                'slug' => 'ordenes-hijo',
                'icon' => null,
                'route' => '/orderform/orderforms',
                'order' => 132,
                'parent_slug' => 'orden-produccion',
                'roles' => ['sadmin', 'pfadmin', 'user']
            ],
            [
                'name' => 'Producción',
                'slug' => 'produccion-hijo',
                'icon' => null,
                'route' => '/orderform/production',
                'order' => 133,
                'parent_slug' => 'orden-produccion',
                'roles' => ['pfproducer']
            ],
            // Ordenes de Almacen Parent
            [
                'name' => 'Ordenes de Almacen',
                'slug' => 'ordenes-almacen',
                'icon' => 'fa fa-sitemap',
                'route' => '/warehouseorder',
                'order' => 140,
                'parent_slug' => null,
                'roles' => ['sadmin']
            ],
            [
                'name' => 'Ordenes de Almacen',
                'slug' => 'ordenes-almacen-hijo',
                'icon' => null,
                'route' => '/warehouseorder/orders',
                'order' => 141,
                'parent_slug' => 'ordenes-almacen',
                'roles' => ['sadmin']
            ],
        ];

        // First pass: insert all parent menus
        $createdMenus = [];
        foreach ($menusList as $m) {
            if ($m['parent_slug'] === null) {
                $menu = Menu::firstOrCreate(['slug' => $m['slug']], [
                    'name' => $m['name'],
                    'icon' => $m['icon'],
                    'route' => $m['route'],
                    'order' => $m['order'],
                    'active' => true
                ]);
                $createdMenus[$m['slug']] = $menu;

                // Sync roles
                $roleIds = [];
                foreach ($m['roles'] as $roleSlug) {
                    $r = Role::where('slug', $roleSlug)->first();
                    if ($r) {
                        $roleIds[$r->id] = ['order' => $m['order']];
                    }
                }
                $menu->roles()->sync($roleIds);
            }
        }

        // Second pass: insert child menus referencing parent_id
        foreach ($menusList as $m) {
            if ($m['parent_slug'] !== null) {
                $parentId = $createdMenus[$m['parent_slug']]->id ?? null;
                $menu = Menu::firstOrCreate(['slug' => $m['slug']], [
                    'parent_id' => $parentId,
                    'name' => $m['name'],
                    'icon' => $m['icon'],
                    'route' => $m['route'],
                    'order' => $m['order'],
                    'active' => true
                ]);

                // Sync roles
                $roleIds = [];
                foreach ($m['roles'] as $roleSlug) {
                    $r = Role::where('slug', $roleSlug)->first();
                    if ($r) {
                        $roleIds[$r->id] = ['order' => $m['order']];
                    }
                }
                $menu->roles()->sync($roleIds);
            }
        }
    }
}
