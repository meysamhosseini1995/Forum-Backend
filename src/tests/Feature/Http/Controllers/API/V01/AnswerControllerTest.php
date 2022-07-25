<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnswerControllerTest extends TestCase
{
    /**
     * @test
     * Test All Answers List Should be Accessible
     */
    public function test_get_all_answer_list_should_be_accessible()
    {
        $response = $this->get(route('answer.index'));

        $response->assertStatus(Response::HTTP_OK);
    }


    /*
     * Test Store Answer
     */
    public function test_store_answer_should_be_validate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('answer.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'thread_id']);
    }


    public function test_store_new_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();
        $response = $this->postJson(route('answer.store'), [
            'content'   => "Foo",
            'thread_id' => $thread->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertTrue($thread->answers()->where('content', "Foo")->exists());
    }

    /*
     * Test Update Answer
     */
    public function test_answer_update_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $answer = Answer::factory()->create();
        $response = $this->putJson(route('answer.update', [$answer]), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content']);
    }

    public function test_answer_update()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $answer = Answer::factory()->create([
            'content'    => fake()->realText(),
            'user_id'    => $user->id,
        ]);
        $response = $this->putJson(route('answer.update', [$answer]), [
            'content'    => "Bar",
        ]);

        $answer->refresh();

        $this->assertEquals("Bar", $answer->content);
        $response->assertStatus(Response::HTTP_OK);
    }



    /*
     * Test Delete Answer
     */

        public function test_answer_delete()
        {
            $user = User::factory()->create();
            Sanctum::actingAs($user);

            $answer = Answer::factory()->create([
                'content'    => fake()->realText(),
                'user_id'    => $user->id,
            ]);
            $response = $this->deleteJson(route('answer.destroy', [$answer]));

            $response->assertStatus(Response::HTTP_OK);
            $this->assertFalse(Thread::find($answer->thread_id)->answers()->whereContent($answer->content)->exists());
        }
}
