<?php

namespace Database\Factories\User\Entity;

use App\Models\User\Entity\UserToken;
use App\Models\User\Entity\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $token = Str::random(64);
            $result = UserToken::where('value', $token)->first();
        } while( !is_null($result) );

        return [
            'user_id' => User::factory()->alreadyHashed(),
            'value'   => $token
        ];
    }
}
