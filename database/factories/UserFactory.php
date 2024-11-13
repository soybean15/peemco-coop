<?php

namespace Database\Factories;

use App\Helpers\IdGenerator;
use App\Models\User;
use App\Models\UserProfile;
use App\Providers\LoanServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $index = 1;
    public function definition(): array
    {



        $this->index++;

        // $formattedNumber = sprintf('%07d', $this->index-1);

        $mid = IdGenerator::generateId('MID',LoanServiceProvider::LOAN_LEN);
        // echo $mid;

        return [
            'mid' => $mid,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'middlename'=>fake()->lastName(),
            'username'=> fake()->userName(),
            'lastname'=>fake()->lastName()
        ];
    }



    public function configure(): static
    {


        return $this->afterCreating(function (User $user) {
            UserProfile::firstOrCreate(['user_id' => $user->id]);
            $user->assignRole('Member');
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
