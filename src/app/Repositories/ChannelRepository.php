<?php
namespace App\Repositories;


use App\Models\Channel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelRepository
{

    /**
     * All Channel list
     */
    public function all(): Collection
    {
        return Channel::all();
    }


    /**
     * @param Request $request
     */
    public function create(Request $request): void
    {
        Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    }

    /**
     * @param Request $request
     */
    public function update(Request $request): void
    {
        Channel::find($request->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        Channel::destroy($id);
    }
}