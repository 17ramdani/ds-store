<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $role_sa = Role::create(['name' => 'super admin']);
        // $role_admin = Role::create(['name' => 'admin']);
        // $role_cs = Role::create(['name' => 'cs']);

        // $user_sa = User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'sa@duniasandang.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // $user_sa->assignRole($role_sa);

        // $user_admin = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@duniasandang.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // $user_admin->assignRole($role_admin);

        // $user_cs = User::create([
        //     'name' => 'Customer Servis',
        //     'email' => 'head@duniasandang.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // $user_cs->assignRole($role_cs);


    }
}
