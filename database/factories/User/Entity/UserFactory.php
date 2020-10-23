<?php

namespace Database\Factories\User\Entity;

use App\Models\User\Entity\User;
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
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password
        ];
    }

    /**
     * Indicate that the users password is hashed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function alreadyHashed()
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => password_hash($attributes['password'], PASSWORD_BCRYPT),
            ];
        });
    }
}
