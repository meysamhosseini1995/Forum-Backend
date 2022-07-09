<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test Register
     */
    public function test_register_should_be_validate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }

    public function test_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name'     => 'Meysam Hosseini',
            'email'    => 'meysamhosseini1995@gmail.com',
            'password' => '12345678'
        ]);
        $response->assertStatus(201);
    }

    /**
     * Test Login
     */
    public function test_login_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(422);
    }

    public function test_user_can_login_with_true_credentials()
    {
        //        $user = User::factory()->create()[0];
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }

    /*
     * Test Logged in user
     */
    public function test_show_user_info_logged_id()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('auth.user'));
        $response->assertStatus(200);
    }

    /*
     * Test Logout
     */
    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }

}
