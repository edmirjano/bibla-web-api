<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayList\Playlist;
use App\Models\Song\Song;
use Illuminate\Http\Request;

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
        return view('playlist.edit', compact('songs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        Playlist::create([
            'title' => $request->title,
            'user_id'=>auth()->user()->id
        ]);

        return redirect()->route('playlist.index')->with('success', 'Playlist created successfully.');
    }

    public function edit(Request $request, Playlist $playlist)
    {
        // Fetch all songs or filter them based on the search query
        $query = Song::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('title', 'LIKE', '%' . $searchTerm . '%');
        }

        $songs = $query->get();

        return view('playlist.edit', compact('playlist', 'songs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $playlist->update([
            'title' => $request->title,
        ]);

        return response()->json(['success' => true]);
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
        return redirect()->route('playlist.index')->with('success', 'Playlist deleted successfully.');
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


    // Update songs in the playlist
    public function updateSongs(Request $request, Playlist $playlist)
    {
        // Validate song input
        $request->validate([
            'songs' => 'array', // Validate it as an array of song IDs
            'songs.*' => 'exists:songs,id' // Each ID must exist in the songs table
        ]);

        // Sync the selected songs with the playlist (add/remove automatically)
        $playlist->songs()->sync($request->songs);

        return redirect()->route('playlist.index', $playlist->id)
            ->with('success', 'Playlist updated successfully.');
    }

}
