<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence(4);
        $user = User::factory()->create();
        $channel = Channel::factory()->create();
        return [
            "title"      => $title,
            "slug"       => Str::slug($title),
            "content"    => fake()->realText(),
            "user_id"    => $user->id,
            "channel_id" => $channel->id,
        ];
    }
}
