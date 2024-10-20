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
        User::factory(10)->create();

        $user =  User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
         ]);
 
         
       $superAdmin=  Role::create(['name'=> 'SuperAdmin', 'guard_name'=>'web']);
         Role::create(['name'=> 'Bookkeeper', 'guard_name'=>'web']);
         Role::create(['name'=> 'Member', 'guard_name'=>'web']);
 
         $user->assignRole($superAdmin);
    }
}
