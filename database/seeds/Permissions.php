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
        // $permission[] = \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.index');
        // $permission[] = \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.pages');

        // $role = \Spatie\Permission\Models\Role::findOrCreate('Normal');
        // $role->syncPermissions($permission);

        // $permission[] = \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.emails');
        // $role = \Spatie\Permission\Models\Role::findOrCreate('Admin');
        // $role->syncPermissions($permission);
        // Define the permissions
$adminPermissions = [
    \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.index'),
    \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.pages'),
    \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.emails'),
];

$normalPermissions = [
    \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.index'),
    \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.pages'),
];

// Define the roles
$adminRole = \Spatie\Permission\Models\Role::findOrCreate('Admin');
$normalRole = \Spatie\Permission\Models\Role::findOrCreate('Normal');

// Sync permissions for the roles
$adminRole->syncPermissions($adminPermissions);
$normalRole->syncPermissions($normalPermissions);

// Assign the role based on the user type
if ($validatedData['type'] == 'admin') {
    $user->assignRole('Admin');
} elseif ($validatedData['type'] == 'normal') {
    $user->assignRole('Normal');
} else {
    // No role assignment for other types (e.g., student)
}
    }
}
