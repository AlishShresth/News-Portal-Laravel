<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);
        $user = Role::create(['name' => 'subscriber']);

        Permission::create(['name' => 'manage articles']);
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'view articles']);

        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['edit articles', 'view articles']);
        $user->givePermissionTo(['view articles']);
    }
}
