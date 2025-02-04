<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $bodeguero = Role::firstOrCreate(['name' => 'bodeguero']); 
        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);

         // ✅ Crear permisos
         $permissions = [
            // Permisos generales
            'ver dashboard',

            // Permisos de productos
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver productos',

            // Permisos de proveedores
            'ver proveedores',

            // Permisos de compras
            'ver compras',

            // Permisos de ventas (NO ASIGNADOS A BODEGUERO)
            'gestionar ventas',


            //permisos de Ventas
            'crear ventas',
            'editar ventas',
            'eliminar ventas',
            'ver ventas',
            //permisos de Clientes
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver clientes',


        ];

        foreach ($permissions as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Asignar permisos a roles
        $admin->givePermissionTo(Permission::all()); // El admin tiene todos los permisos

        $user->givePermissionTo(['ver dashboard', 'ver compras']);

        $bodeguero->givePermissionTo([
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver productos',
            'ver proveedores' // Solo puede ver proveedores, no editarlos ni eliminarlos.
        ]);

        //permisos para el vendedor
        $vendedor->givePermissionTo([
            'crear ventas',
            'editar ventas',
            'eliminar ventas',
            'ver ventas',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver clientes'
        ]);
    }
}
