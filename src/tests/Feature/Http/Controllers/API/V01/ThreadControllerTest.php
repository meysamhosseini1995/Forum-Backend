<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadControllerTest extends TestCase
{
    /**
     * @test
     * Test All Threads List Should be Accessible
     */
    public function test_get_all_thread_list_should_be_accessible()
    {
        $response = $this->get(route('thread.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * Test Get Thread By Slug
     */
    public function test_thread_should_be_accessible_by_slug()
    {
        $thread = Thread::factory()->create();
        $response = $this->get(route('thread.show', [$thread]));

        $response->assertStatus(Response::HTTP_OK);
    }

    /*
     * Test Store Thread
     */
    public function test_store_thread_should_be_validate()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('thread management');
        Sanctum::actingAs($user);

        $response = $this->postJson(route('thread.store'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_store_new_thread()
    {

        $user = User::factory()->create();
        $user->givePermissionTo('thread management');
        Sanctum::actingAs($user);

        $channel = Channel::factory()->create();
        $response = $this->postJson(route('thread.store'), [
            'title'      => fake()->sentence(4),
            'content'    => fake()->realText(),
            'channel_id' => $channel->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /*
     * Test Update Thread
     */
    public function test_thread_update_should_be_validated()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('thread management');
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();
        $response = $this->putJson(route('thread.update', [$thread]));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_thread_update()
    {

        $user = User::factory()->create();
        $user->givePermissionTo('thread management');
        Sanctum::actingAs($user);

        $channel = Channel::factory()->create();
        $thread = Thread::factory()->create();
        $response = $this->putJson(route('thread.update', [$thread]), [
            'title'      => 'Vue Js',
            'content'    => fake()->realText(),
            'channel_id' => $channel->id,
        ]);

        $thread->refresh();

        $this->assertEquals('Vue Js', $thread->title);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_add_best_answer_id_for_thread()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->givePermissionTo('thread management');
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();
        $response = $this->putJson(route('thread.update', [$thread]), [
            'best_answer_id' => 1,
        ]);

        $thread->refresh();

        $this->assertEquals('1', $thread->best_answer_id);
        $response->assertStatus(Response::HTTP_OK);
    }


    /*
     * Test Delete Thread
     */

    public function test_thread_delete()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('thread management');
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();
        $response = $this->deleteJson(route('thread.destroy', [$thread]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
