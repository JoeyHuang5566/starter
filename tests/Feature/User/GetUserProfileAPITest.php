<?php

namespace Tests\Feature\User;

use App\Models\User\Entity\User;
use App\Models\User\Entity\UserToken;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserProfileAPITest extends TestCase
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
                'id'    => $registeredMember->id,
                'name'  => $registeredMember->name,
                'email' => $registeredMember->email
            ]);
    }

    /**
     * @test
     */
    public function fail_api_token_is_not_correct()
    {

        $response = $this->postJson(
            $this->url, 
            [
                'api_token' => '12345678'
            ]
        );

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function fail_api_token_is_null()
    {

        $response = $this->postJson(
            $this->url, 
            []
        );

        $response->assertStatus(401);
    }
}
