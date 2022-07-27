<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubscribeControllerTest extends TestCase
{
    /**
     * @test
     * Test User Can Be Subscribe to a channel
     */
    public function user_can_subscribe_to_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();
        $response = $this->postJson(route('subscribe', [$thread]));

        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @test
     * Test User Can Be Subscribe to a channel
     */
    public function user_can_unsubscribe_to_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();
        $response = $this->postJson(route('unSubscribe', [$thread]));

        $response->assertStatus(Response::HTTP_OK);
    }


    public function notification_will_send_to_subscribers_of_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Notification::fake();

        $thread = Thread::factory()->create();

        $subscribe_response = $this->postJson(route('subscribe', [$thread]));
        $subscribe_response->assertStatus(Response::HTTP_OK);

        $answer_response = $this->postJson(route('answer.store', [
            "content" => "Foo",
            "thread_id" => $thread->id,
        ]));

        $answer_response->assertStatus(Response::HTTP_OK);

        Notification::assertSentTo($user,NewReplySubmitted::class);
    }
}
