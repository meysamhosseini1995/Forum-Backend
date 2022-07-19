<?php

namespace Tests\Feature\Http\Controllers\API\V01;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    /**
     * Test All Channels List Should be Accessible
     */
    public function test_get_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /*
     * Test Create Channel
     */
    public function test_store_channel_should_be_validate()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        Sanctum::actingAs($user);

        $response = $this->postJson(route('channel.store'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_create_new_channel()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        Sanctum::actingAs($user);

        $response = $this->postJson(route('channel.store'), [
            'name' => 'Laravel'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /*
     * Test Update Channel
     */
    public function test_channel_update_should_be_validated()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        Sanctum::actingAs($user);

        $response = $this->putJson(route('channel.update', ['channel' => 0]));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        Sanctum::actingAs($user);

        $channel = Channel::factory()->create([
            'name' => 'Laravel'
        ]);
        $response = $this->putJson(route('channel.update', ['channel' => $channel->id]), [
            'name' => 'Vue Js',
        ]);

        $updatedChannel = Channel::find($channel->id);

        $this->assertEquals('Vue Js', $updatedChannel->name);
        $response->assertStatus(Response::HTTP_OK);
    }


    /*
     * Test Delete Channel
     */
    //    public function test_channel_delete_should_be_validated()
    //    {
    //        $response = $this->deleteJson(route('channel.destroy',['channel'=>0]));
    //
    //        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    //    }

    public function test_channel_delete()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        Sanctum::actingAs($user);
        
        $channel = Channel::factory()->create([
            'name' => 'Laravel'
        ]);
        $response = $this->deleteJson(route('channel.destroy', ['channel' => $channel->id]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
