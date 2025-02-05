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

        // ✅ Definir permisos
        $permissions = [
            // Permisos generales
            'ver dashboard',
            // Permisos de compras
            'ver compras',
            // Permisos de ventas (NO ASIGNADOS A BODEGUERO)
            'gestionar ventas',
            // Permiso para ver Kardex
            'ver kardex',

            // Permisos de productos
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver productos',

            // Permisos de ventas
            'crear ventas',
            'editar ventas',
            'eliminar ventas',
            'ver ventas',

            // Permisos de clientes
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver clientes',

            // Permisos de compras
            'crear compras',
            'editar compras',
            'eliminar compras',
            'ver compras',

            // Permisos de proveedores
            'crear proveedores',
            'editar proveedores',
            'eliminar proveedores',
            'ver proveedores',
        ];

        // ✅ Crear permisos en la base de datos
        foreach ($permissions as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ✅ Asignar TODOS los permisos al rol admin
        $admin->syncPermissions(Permission::all());

        // ✅ Asignar permisos específicos a los demás roles
        $user->syncPermissions(['ver dashboard', 'ver compras']);

        $bodeguero->syncPermissions([
            'crear productos',
            'editar productos',
            'eliminar productos',
            'ver productos',
            'ver proveedores',  
            'ver kardex'
        ]);

        $vendedor->syncPermissions([
            'crear ventas',
            'editar ventas',
            'eliminar ventas',
            'ver ventas',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'ver clientes'
        ]);

        $adminProveedor->syncPermissions([
            'crear proveedores',
            'editar proveedores',
            'eliminar proveedores',
            'ver proveedores',
            'crear compras',
            'editar compras',
            'eliminar compras',
            'ver compras'
        ]);
    }
}
