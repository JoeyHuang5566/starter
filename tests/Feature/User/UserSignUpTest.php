<?php

namespace Tests\Feature\User;

use App\Models\User\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSignUpTest extends TestCase
{
    use RefreshDatabase;

    protected $url = '/api/users/signup';

    /**
     * @test
     */
    public function user_sign_up_successfully()
    {

        $userData = [
                'name'     => 'Sally',
                'password' => '12345678',
                'email'    => 'example@example.com'
            ];

        $response = $this->postJson(
            $this->url, 
            $userData
        );

        $response
            ->assertStatus(200)
            ->assertJson([]);;
    }

    /**
     * @test
     */
    public function email_is_duplicate()
    {

        $taylor = User::create([
            'name'     => 'Taylor',
            'password' => '88888888',
            'email'    => 'example@example.com',
        ]);
        $taylor->save();

        $userData = [
                'name'     => 'Sally',
                'password' => '12345678',
                'email'    => $taylor->email
            ];

        $response = $this->postJson(
            $this->url, 
            $userData
        );

        $response
            ->assertStatus(403)
            ->assertJson([
             "error_name" => "illegal_form_input",
             "validation" => [
                     "email" => [
                         "The email is registered."
                     ]
                 ]
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
            'no_name_data'    => [
                [
                    'password' => '12345678',
                    'email'    => 'example@example.com'
                ],
                [
                    "error_name" => "illegal_form_input",
                    "validation" => [
                            "name" => [
                                "required"
                            ]
                    ]
                ]
            ],
            'no_password_data' => [
                [
                    'name'  => 'John Doe',
                    'email' => 'example@example.com'
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
                    'name'     =>'John Doe',
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
