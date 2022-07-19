<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\SeedDatabaseState;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
//    use RefreshDatabase;

//    public function setUp() : void
//    {
//        $this->seed(RoleAndPermissionSeeder::class);
//    }

    public function setUp() : void
    {
        parent::setUp();
        SeedDatabaseState::$seeders = [RoleAndPermissionSeeder::class];
        $this->seedDatabase();
    }

    /**
     * Test Register
     */
    public function test_register_should_be_validated()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name'     => fake()->name,
            'email'    => fake()->email,
            'password' => '12345678'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test Login
     */
    public function test_login_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_can_login_with_true_credentials()
    {
        //        $user = User::factory()->create()[0];
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /*
     * Test Logged in user
     */
    public function test_show_user_info_logged_id()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('auth.user'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /*
     * Test Logout
     */
    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(Response::HTTP_OK);
    }

}
