<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('role_has_permissions')->truncate();
        //\DB::table('model_has_permissions')->truncate();
        \DB::table('model_has_roles')->truncate();
        //\DB::table('permissions')->truncate();
        //\DB::table('roles')->truncate();

        $role = Role::firstOrCreate(['name' => 'admin']);
        $permission = Permission::firstOrCreate(['name' => 'access_backend']);
        $role->givePermissionTo($permission);
    }
}
