<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $editPermission = \App\Models\Permission::firstOrCreate(
            ['slug' => 'orderforms.edit'],
            [
                'company_id' => 1,
                'name' => 'Editar Ordenes de Pedido',
                'description' => 'Permite editar y aprobar ordenes de pedido'
            ]
        );

        $deletePermission = \App\Models\Permission::firstOrCreate(
            ['slug' => 'orderforms.delete'],
            [
                'company_id' => 1,
                'name' => 'Eliminar Ordenes de Pedido',
                'description' => 'Permite eliminar ordenes de pedido'
            ]
        );

        $adminRole = \App\Models\Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching([
                $editPermission->id,
                $deletePermission->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $adminRole = \App\Models\Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $editPermission = \App\Models\Permission::where('slug', 'orderforms.edit')->first();
            $deletePermission = \App\Models\Permission::where('slug', 'orderforms.delete')->first();
            if ($editPermission) {
                $adminRole->permissions()->detach($editPermission->id);
            }
            if ($deletePermission) {
                $adminRole->permissions()->detach($deletePermission->id);
            }
        }
    }
};
