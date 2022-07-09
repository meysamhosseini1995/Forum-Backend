<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    /**
     * Test All Channels List Should be Accessible
     */
    public function test_get_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channels.all'));

        $response->assertStatus(200);
    }

    /*
     * Test Create Channel
     */
    public function test_created_channel_should_be_validate()
    {
        $response = $this->postJson(route('channels.create'));

        $response->assertStatus(422);
    }


    public function test_create_new_channel()
    {
        $response = $this->postJson(route('channels.create'),[
            'name' => 'Laravel'
        ]);

        $response->assertStatus(201);
    }
}
