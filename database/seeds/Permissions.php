<?php

use Illuminate\Database\Seeder;
use App\User;

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
    \Spatie\Permission\Models\Permission::findOrCreate('studentcontroller.add-info'),
    \Spatie\Permission\Models\Permission::findOrCreate('studentcontroller.change-password'),
];

$normalPermissions = [
    \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.index'),
    \Spatie\Permission\Models\Permission::findOrCreate('homecontroller.pages'),
    \Spatie\Permission\Models\Permission::findOrCreate('studentcontroller.add-info'),
    \Spatie\Permission\Models\Permission::findOrCreate('studentcontroller.change-password'),
];


// Define the roles
$adminRole = \Spatie\Permission\Models\Role::findOrCreate('Admin');
$normalRole = \Spatie\Permission\Models\Role::findOrCreate('Normal');

// Sync permissions for the roles
$adminRole->syncPermissions($adminPermissions);
$normalRole->syncPermissions($normalPermissions);

// Assign the role based on the user type
// if ($validatedData['type'] == 'admin') {
//     $user->assignRole('Admin');
// } elseif ($validatedData['type'] == 'normal') {
//     $user->assignRole('Normal');
// } else {
//     // No role assignment for other types (e.g., student)
// }
$users = User::all(); // Fetch all users

        foreach ($users as $user) {
            if ($user->type == 'admin') {
                $user->assignRole('Admin');
            } elseif ($user->type == 'normal') {
                $user->assignRole('Normal');
            }
        }
    }
}
