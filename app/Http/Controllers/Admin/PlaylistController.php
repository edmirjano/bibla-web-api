<?php

namespace App\Http\Controllers\Admin;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        $playlists = Playlist::all();
        if ($request->wantsJson()) {
            return response()->json($playlists);
        } else {
            return view('playlist.index', compact('playlists'));
        }
    }

    public function create()
    {
        $songs = Song::all();
        return view('playlist.create', compact('songs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $playlist = new Playlist();
        $playlist->title = $request->title;
        $playlist->user_id = $request->user_id;
        $playlist->save();

        if ($request->songs) {
            $playlist->songs()->attach($request->songs);
        }

        if ($request->wantsJson()) {
            return response()->json($playlist);
        } else {
            return redirect()->route('playlist.index');
        }
    }

    public function edit(Playlist $playlist)
    {
        $songs = Song::all();
        return view('playlist.edit', compact('playlist', 'songs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist->name = $request->name;
        $playlist->update();

        if ($request->songs) {
            $playlist->songs()->sync($request->songs);
        }

        return redirect()->route('playlist.index');
    }


    public function createPlaylistFromUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist = new Playlist();
        $playlist->title = $request->title;
        $playlist->user_id = $request->id();
        $playlist->save();

        if ($request->songs) {
            $playlist->songs()->attach($request->songs);
        }

        return redirect()->route('playlist.index');
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route('playlist.index');
    }

    public function getPlaylists()
    {
        $playlists = Playlist::with('songs')->get();
        return response()->json($playlists);
    }

    public function createPlaylist(Request $request){
        $playlist = new Playlist();
        $playlist->title = $request->title;
        $playlist->number_of_songs = count($request->songs);
        $playlist->user_id = $request->user_id;
        $playlist->save();
        $playlist->songs()->attach($request->songs);

        return response()->json($playlist);
    }
}
