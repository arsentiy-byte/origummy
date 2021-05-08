<?php

namespace Database\Factories;

use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->name(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'password' => Hash::make('1234'),
            'address' => $this->faker->address,
            'is_admin' => $this->faker->boolean
        ];
    }
}
