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
        $query = $request->input('search');
        $playlists = Playlist::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('title', 'like', "%{$query}%");
        })->paginate(10);

        if ($request->wantsJson()) {
            return response()->json(['playlists' => $playlists]);
        } else {
            return view('playlist.index', compact('playlists', 'query'));
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
            'user_id'=>auth()->user()->id,
            "is_from_admin"=>true

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




    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route('playlist.index')->with('success', 'Playlist deleted successfully.');
    }
    public function trashed(Request $request)
    {
        $query = $request->input('search');

        $playlists = Playlist::onlyTrashed()
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%{$query}%");
            })
            ->paginate(10);

        return view('playlist.trashed', compact('playlists', 'query'));
    }

    public function restore($id)
    {
        $playlist = Playlist::onlyTrashed()->findOrFail($id);
        $playlist->restore();

        return redirect()->route('playlist.trashed')->with('success', 'Playlist restored successfully.');
    }



    public function updateSongs(Request $request, Playlist $playlist)
    {
        $request->validate([
            'songs' => 'array', // Validate it as an array of song IDs
            'songs.*' => 'exists:songs,id' // Each ID must exist in the songs table
        ]);

        $playlist->songs()->sync($request->songs);

        return redirect()->route('playlist.index', $playlist->id)
            ->with('success', 'Playlist updated successfully.');
    }

}
