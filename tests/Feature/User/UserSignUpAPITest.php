<?php

namespace Tests\Feature\User;

use App\Models\User\Entity\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSignUpAPITest extends TestCase
{

    protected $url = '/api/users/signup';

    /**
     * @test
     */
    public function user_sign_up_successfully()
    {
        $someone = User::factory()->make();

        $response = $this->postJson(
            $this->url, 
            $someone->toArray()
        );

        $response
            ->assertStatus(200)
            ->assertJson([]);

        $this->assertDatabaseHas(
            'users',
            [
                'name'  => $someone->name,
                'email' => $someone->email
            ]
        );
    }

    /**
     * @test
     */
    public function email_is_duplicate()
    {

        $registeredMember = User::factory()->create();
        $someone = User::factory()->make();

        $someone->email = $registeredMember->email;

        $response = $this->postJson(
            $this->url, 
            $someone->toArray()
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
