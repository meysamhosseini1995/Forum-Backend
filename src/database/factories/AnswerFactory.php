<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        return [
            "content"   => fake()->realText(),
            "user_id"   => $user->id,
            "thread_id" => $thread->id,
        ];
    }
}
