<?php

namespace Tests\Feature\User;

use App\Models\User\Entity\User;
use App\Models\User\Entity\UserToken;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserProfileTest extends TestCase
{

    protected $url = '/api/users/profile';

    /**
     * @test
     */
    public function get_user_self_profile_successfully()
    {

        $token = UserToken::factory()->create();
        $registeredMember = $token->user;

        $response = $this->postJson(
            $this->url, 
            [
                'api_token' => $token->value
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'id'    => $someone->id,
                'name'  => $someone->name,
                'email' => $someone->email
            ]);;
    }
}
