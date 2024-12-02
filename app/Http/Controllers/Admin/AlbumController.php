<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album\Album;
use App\Models\PlayList\Playlist;
use App\Models\Song\Song;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $albums = Album::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('title', 'like', "%{$query}%");
        })->get();

        if ($request->wantsJson()) {
            return response()->json(['albums' => $albums]);
        } else {
            return view('album.index', compact('albums', 'query'));
        }
    }

    public function create()
    {
        $songs = Song::all();
        return view('album.edit', compact('songs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        Album::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id,
            "is_from_admin" => true

        ]);

        return redirect()->route('album.index')->with('success', 'Album created successfully.');
    }

    public function edit(Request $request, Album $album)
    {
        // Fetch all songs or filter them based on the search query
        $query = Song::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('title', 'LIKE', '%' . $searchTerm . '%');
        }

        $songs = $query->get();

        return view('album.edit', compact('album', 'songs'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $album->update([
            'title' => $request->title,
        ]);

        return response()->json(['success' => true]);
    }




    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('album.index')->with('success', 'Album deleted successfully.');
    }




    public function updateSongs(Request $request, Album $album)
    {
        $request->validate([
            'songs' => 'array', // Validate it as an array of song IDs
            'songs.*' => 'exists:songs,id' // Each ID must exist in the songs table
        ]);

        $album->songs()->sync($request->songs);

        return redirect()->route('album.index', $album->id)
            ->with('success', 'Album updated successfully.');
    }

}
