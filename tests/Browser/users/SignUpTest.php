<?php

namespace Tests\Browser\users;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SignUpTest extends DuskTestCase
{

    protected $url = '/users/signup';

    /**
     * @test
     */
    public function user_can_see_the_sign_up_page()
    {
        $response = $this->get($this->url);

        $response->assertStatus(200);

        $this->browse(function (Browser $browser) {
            $browser->visit($this->url)
                    ->assertSee('Name')
                    ->assertSee('Email')
                    ->assertSee('Password');
        });
    }

    /**
     * @test
     */
    public function user_can_register_from_sign_up_page()
    {
        $user = [
            'name' => 'Joey',
            'email' => 'joey@example.com',
            'password' => '12345678'
        ];

        $this->browse(function (Browser $browser) use($user) {
            $browser->visit($this->url)
                    ->assertRouteIs('getSignUp')
                    ->type('name', $user['name'])
                    ->type('email', $user['email'])
                    ->type('password', $user['password'])
                    ->press('Submit')
                    ->assertRouteIs('postSignUp');

            $this->assertDatabaseHas(
                'users',
                [
                    'name'  => $user['name'],
                    'email' => $user['email']
                ]
            );
        });

    }

}
