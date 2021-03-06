<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    public function up()
    {
        // Need to clear the cache, otherwise it will report an error
        app(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions first
        Permission::create(['name' => 'manage_contents']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'edit_settings']);

        // Create a webmaster role and give permissions
        $founder = Role::create(['name' => 'Founder']);
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_settings');

        // Create an admin role and give permissions
        $maintainer = Role::create(['name' => 'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');
    }

    public function down()
    {
        // Need to clear the cache, otherwise it will report an error
        app(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Clear all data table data
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
