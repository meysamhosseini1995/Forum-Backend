<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    /**
     * Test All Channels List Should be Accessible
     */
    public function test_get_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channels.all'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /*
     * Test Create Channel
     */
    public function test_created_channel_should_be_validate()
    {
        $response = $this->postJson(route('channels.create'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_create_new_channel()
    {
        $response = $this->postJson(route('channels.create'),[
            'name' => 'Laravel'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
    
    /*
     * Test Update Channel
     */
    public function test_channel_update_should_be_validated()
    {
        $response = $this->putJson(route('channels.update'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update()
    {
        $channel = Channel::factory()->create([
            'name'=>'Laravel'
        ]);
        $response = $this->putJson(route('channels.update'),[
            'id' => $channel->id,
            'name' => 'Vue Js',
        ]);

        $updatedChannel = Channel::find($channel->id);

        $this->assertEquals( 'Vue Js', $updatedChannel->name);
        $response->assertStatus(Response::HTTP_OK);
    }


    /*
     * Test Delete Channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $response = $this->deleteJson(route('channels.delete'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_delete()
    {
        $channel = Channel::factory()->create([
            'name'=>'Laravel'
        ]);
        $response = $this->deleteJson(route('channels.delete'),[
            'id' => $channel->id,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
