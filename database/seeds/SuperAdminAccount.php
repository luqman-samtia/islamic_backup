<?php

use App\User;
use Illuminate\Database\Seeder;

class SuperAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = User::where('email', 'admin@admin.com')->exists();
        if(!$check) {
            $user = User::create(['name' => 'Super Admin', 'email' => 'admin@admin.com', 'password' => \Illuminate\Support\Facades\Hash::make('12345678')]);
            $user->syncRoles('SuperAdmin');
        }
    }
}
