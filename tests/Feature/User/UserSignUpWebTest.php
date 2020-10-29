<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSignUpWebTest extends TestCase
{

    protected $url = '/users/signup';

    /**
     * @test
     */
    public function user_can_see_the_sign_up_page()
    {
        $response = $this->get($this->url);

        $response
            ->assertStatus(200)
            ->assertViewIs('users.signup')
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Password');
    }
}
