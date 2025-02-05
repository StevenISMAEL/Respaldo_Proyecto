<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // ✅ Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $bodeguero = Role::firstOrCreate(['name' => 'bodeguero']); 
        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);
        $adminProveedor = Role::firstOrCreate(['name' => 'adminProveedor']);

        // ✅ Crear permisos
        $permissions = [
            // Permisos generales
            'ver dashboard',

            // Permisos de productos
            'gestionar productos',
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver productos',

            // Permisos de proveedores
            'gestionar proveedores',
            'crear proveedores',
            'editar proveedores',
            'eliminar proveedores',
            'ver proveedores',

            // Permisos de kardex
            'ver kardex',

            // Permisos de ventas
            'gestionar ventas',
            'crear ventas',
            'editar ventas',
            'eliminar ventas',
            'ver ventas',

            // Permisos de clientes
            'gestionar clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver clientes',

            // Permisos de compras
            'gestionar compras',
            'crear compras',
            'editar compras',
            'eliminar compras',
            'ver compras',

            // Permisos de roles
            'gestionar roles',
            'crear roles',
            'editar roles',
            'eliminar roles',
            'ver roles',

            // Permisos de permisos
            'ver configuracion_datos',
            'gestionar configuracion_datos'

        ];

        foreach ($permissions as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ✅ Asignar permisos a roles
        $admin->givePermissionTo(Permission::all()); // Admin tiene **TODOS** los permisos

        $user->givePermissionTo(['ver dashboard', 'ver compras']);

        // ✅ Permisos para el bodeguero
        $bodeguero->givePermissionTo([
            // 'gestionar productos',
            // 'crear productos',
            // 'editar productos',
            // 'eliminar productos',
            'ver productos',
            'ver proveedores',
            'ver kardex'
        ]);

        // ✅ Permisos para el vendedor
        $vendedor->givePermissionTo([
            // 'crear ventas',
            // 'editar ventas',
            // 'eliminar ventas',
            // 'crear clientes',
            // 'editar clientes',
            // 'eliminar clientes',
            'ver clientes',
            'ver ventas',
        ]);

        // ✅ Permisos para el admin de proveedores
        $adminProveedor->givePermissionTo([
            'crear proveedores',
            'editar proveedores',
            'eliminar proveedores',
            // 'crear compras',
            // 'editar compras',
            // 'eliminar compras',
            'ver proveedores',
            'ver productos',

            'ver compras'
        ]);
    }
}
