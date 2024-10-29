<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use App\Services\Seeders\RoleAndPermissionSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {



        RoleAndPermissionSeeder::seed();

        $user = User::factory(200)->create();

        $user =  User::factory()->create([
            'mid' => 'MID00000201',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);


        $user->assignRole(RolesEnum::SUPER_ADMIN->value);
    }
}
