<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use App\Services\Seeders\RoleAndPermissionSeeder;
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



        RoleAndPermissionSeeder::seed();

        $user = User::factory(150)->create();

        $user =  User::factory()->create([
            'mid' => 'MID-0000000',
            'name' => 'Test User',
            'username'=>'TestUser',
            'email' => env('SUPER_ADMIN','test@example'),
        ]);


        $user->assignRole(RolesEnum::SUPER_ADMIN->value);
    }
}
