<?php

namespace Tests\Feature\User;

use App\Models\User\Entity\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSignInTest extends TestCase
{

    protected $url = '/api/users/signin';

    /**
     * @test
     */
    public function user_sign_in_successfully()
    {

        $password = "88888888";
        $taylor = User::create([
            'name'     => 'Taylor',
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'email'    => 'example@example.com',
        ]);

        $userData = [
                'email'    => $taylor->email,
                'password' => $password
            ];

        $response = $this->postJson(
            $this->url, 
            $userData
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'api_token' => $taylor->getLatestTokenValue()
            ]);;
    }

    /**
     * @test
     */
    public function password_is_not_correct()
    {

        $password = "88888888";
        $taylor = User::create([
            'name'     => 'Taylor',
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'email'    => 'example@example.com',
        ]);

        $userData = [
                'email'    => $taylor->email,
                'password' => '12345678'
            ];

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
