<?php

namespace App\Http\Controllers\Admin;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::all();
        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        $songs = Song::all();
        return view('playlists.create', compact('songs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->save();

        if($request->songs){
            $playlist->songs()->attach($request->songs);
        }

        return redirect()->route('playlist.index');
    }

    public function edit(Playlist $playlist)
    {
        $songs = Song::all();
        return view('playlists.edit', compact('playlist', 'songs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist->name = $request->name;
        $playlist->update();

        if($request->songs){
            $playlist->songs()->sync($request->songs);
        }

        return redirect()->route('playlist.index');
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route('playlist.index');
    }
}
