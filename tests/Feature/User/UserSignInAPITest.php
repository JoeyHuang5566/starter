<?php

namespace Tests\Feature\User;

use App\Models\User\Entity\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSignInAPITest extends TestCase
{

    protected $url = '/api/users/signin';

    /**
     * @test
     */
    public function user_sign_in_successfully()
    {

        $someone = User::factory()->make();
        $userData = $someone->toArray();

        $someone->password = password_hash($someone->password, PASSWORD_BCRYPT);
        $someone->save();

        $response = $this->postJson(
            $this->url, 
            $userData
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'api_token' => $someone->getLatestTokenValue()
            ]);;
    }

    /**
     * @test
     */
    public function password_is_not_correct()
    {

        $registeredMember = User::factory()->make();
        $userData = $registeredMember->toArray();
        $userData['password'] = 'wrong_password';

        $registeredMember->password = password_hash($registeredMember->password, PASSWORD_BCRYPT);
        $registeredMember->save();

        $response = $this->postJson(
            $this->url, 
            $userData
        );

        $response
            ->assertStatus(403)
            ->assertJson([
                "error_name" => "input_data_error"
            ]);
    }

    /**
     * @test
     * @dataProvider lackInputingData
     */
    public function fail_with_lack_of_input_data($userData, $errorMessage)
    {

        $response = $this->postJson(
            $this->url, 
            $userData
        );

        $response
            ->assertStatus(403)
            ->assertJson($errorMessage);
    }

    public function lackInputingData()
    {
        return [
            'no_password_data' => [
                [
                    'name'  => 'John Doe'
                ],
                [
                    "error_name" => "illegal_form_input",
                    "validation" => [
                            "password" => [
                                "required"
                            ]
                    ]
                ]
            ],
            'no_email_data' => [
                [
                    'password' => '12345678'
                ],
                [
                    "error_name" => "illegal_form_input",
                    "validation" => [
                            "email" => [
                                "required"
                            ]
                    ]
                ]
            ]
        ];
    }
}
