<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $user = User::create([
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
        $admin = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        $user->roles()->attach($userRole);
        $admin->roles()->attach($adminRole);


    }
}