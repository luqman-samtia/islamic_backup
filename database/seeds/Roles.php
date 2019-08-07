<?php

use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Spatie\Permission\Models\Role::findOrCreate('SuperAdmin');
        \Spatie\Permission\Models\Role::findOrCreate('Admin');
        \Spatie\Permission\Models\Role::findOrCreate('Normal');
    }
}
