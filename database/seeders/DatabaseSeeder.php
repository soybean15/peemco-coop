<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $superAdmin =  Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        Role::create(['name' => 'Bookkeeper', 'guard_name' => 'web']);
        Role::create(['name' => 'Member', 'guard_name' => 'web']);
        $user = User::factory(200)->create();

        $user =  User::factory()->create([
            'mid' => 'MID00000201',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);



        $user->assignRole($superAdmin);
    }
}
