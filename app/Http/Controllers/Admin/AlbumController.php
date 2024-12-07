<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album\Album;
use App\Models\Author\Author;
use App\Models\Song\Song;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $albums = Album::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('title', 'like', "%{$query}%");
        })->paginate(10);

        if ($request->wantsJson()) {
            return response()->json(['albums' => $albums]);
        } else {
            return view('albums.index', compact('albums', 'query'));
        }
    }

    public function create()
    {
        $songs = Song::all();
        $authors = Author::all();
        return view('album.edit', compact('songs', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $album = new Album();
        $album->title = $request->title;
        $album->save();

        $album->authors()->attach($request['authors']);
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
        $authors = Author::all();
        return view('albums.edit', compact('album', 'songs', 'authors'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'nullable|array',
            'authors.*' => 'nullable|exists:authors,id',
            'songs' => 'array',
            'songs.*' => 'exists:songs,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        $coverPath = $album->cover;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/songs/cover', $coverName);
        }
        $album->title = $request->title;
        $album->cover = $coverPath ? asset('storage/songs/cover/' . basename($coverPath)) : "";

        $album->save();
        $album->authors()->sync($request->authors);  // Sync authors with the album

        return response()->json(['success' => true]);
    }




    public function destroy(Album $album)
    {
        $album->delete();
        $album->authors()->detach();
        return redirect()->route('album.index')->with('success', 'Album deleted successfully.');
    }




    public function updateSongs(Request $request, Album $album)
    {
        // Validate the incoming request
        $request->validate([
            'songs' => 'array', // Validate the 'songs' as an array of IDs
            'songs.*' => 'exists:songs,id' // Ensure each song ID exists in the songs table
        ]);

        // Get the current songs in the album (using the relationship)
        $currentSongIds = $album->songs->pluck('id')->toArray();

        // Determine which songs are to be added (present in the request but not in the current album)
        $songsToAdd = array_diff($request->songs ?? [], $currentSongIds);

        // Determine which songs are to be removed (present in the album but not in the request)
        $songsToRemove = array_diff($currentSongIds, $request->songs ?? []);

        // Check if any songs are already assigned to another album
        $songsAlreadyInAlbum = Song::whereIn('id', $songsToAdd)
            ->whereNotNull('album_id')
            ->where('album_id', '!=', $album->id)
            ->get();

        // If there are songs already assigned to another album, return an error
        if ($songsAlreadyInAlbum->isNotEmpty()) {
            $errorMessage = 'The following songs are already assigned to other albums: ';
            $errorMessage .= $songsAlreadyInAlbum->pluck('title')->join(', ');

            return redirect()->route('album.index', $album->id)
                ->withErrors(['songs' => $errorMessage])
                ->withInput();
        }

        // Add new songs to the album
        if (!empty($songsToAdd)) {
            // Update the album_id for the songs to be added
            Song::whereIn('id', $songsToAdd)->update(['album_id' => $album->id]);
        }

        // Remove songs from the album
        if (!empty($songsToRemove)) {
            // Update the album_id to null for the songs to be removed
            Song::whereIn('id', $songsToRemove)->update(['album_id' => null]);
        }

        // Redirect to the album index page with a success message
        return redirect()->route('album.index', $album->id)
            ->with('success', 'Album updated successfully.');
    }

}
