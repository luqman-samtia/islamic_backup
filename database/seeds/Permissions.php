<?php

use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission[] = \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.index');
        $permission[] = \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.pages');

        $role = \Spatie\Permission\Models\Role::findOrCreate('Normal');
        $role->syncPermissions($permission);

        $permission[] = \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.emails');
        $role = \Spatie\Permission\Models\Role::findOrCreate('Admin');
        $role->syncPermissions($permission);
    }
}
