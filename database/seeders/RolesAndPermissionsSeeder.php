<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'product.view', 'product.create', 'product.edit', 'product.delete',
            'order.view', 'order.create', 'order.edit', 'order.delete',
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'settings.view', 'settings.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $staff      = Role::firstOrCreate(['name' => 'staff']);

        $admin->syncPermissions(Permission::all());

        $staff->syncPermissions([
            'product.view', 'product.create',
            'order.view', 'order.create',
        ]);
    }
}
