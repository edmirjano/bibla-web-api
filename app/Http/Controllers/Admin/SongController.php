<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album\Album;
use App\Models\Author\Author;
use App\Models\PlayList\Playlist;
use App\Models\Song\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $songs = Song::withTrashed()  // Include soft-deleted songs
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%{$query}%")
                    ->orWhereHas('author', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    });
            })->paginate(10);

        return view('song.index', compact('songs', 'query'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        session(['previous_url' => url()->previous()]);
        $playlists = Playlist::all();
        $authors = Author::all();
        $albums = Album::all();
        return view('song.edit', compact('authors', 'playlists', 'albums'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'authors' => 'nullable|array',
                'authors.*' => 'nullable|exists:authors,id',
                'playlists' => 'nullable|array',
                'playlists.*' => 'exists:playlists,id',
                'album_id' => 'nullable|exists:albums,id',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                'mp3link' => 'required|mimes:mp3',
                'yt_link' => 'nullable|string|max:255',
                'spotify_link' => 'nullable|string|max:255',
                'lyrics' => 'nullable|string',
                'release_year' => 'nullable|integer'
            ],
            [
                'mp3link.mimes' => 'The music file must be an MP3 format.',
                'mp3link.required' => 'The Music field is required.',
            ]
        );

        // Handle the cover file
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/songs/cover', $coverName);
        } else {
            $coverPath = null;
        }

        // Handle the mp3 file
        if ($request->hasFile('mp3link')) {
            $mp3link = $request->file('mp3link');
            $mp3linkName = time() . '.' . $mp3link->getClientOriginalExtension();
            $mp3linkPath = $mp3link->storeAs('public/songs/mp3', $mp3linkName);
        }

        // Create a new Song instance
        $song = new Song();
        $song->title = $request->title;
        $song->album_id = $request->album_id;
        $song->cover = $coverPath ? asset('storage/songs/cover/' . basename($coverPath)) : "";
        $song->mp3link = $mp3linkPath ? asset("storage/songs/mp3/" . basename($mp3linkPath)) : "";
        $song->yt_link = $request->yt_link;
        $song->spotify_link = $request->spotify_link;
        $song->lyrics = $request->lyrics;
        $song->release_year = $request->release_year;

        $song->save();
        $song->playlists()->attach($request['playlists']);
        $song->authors()->attach($request['authors']);
        return redirect()->route('song.index');
    }


    public function edit(Song $song)
    {
        session(['previous_url' => url()->previous()]);

        $authors = Author::all();
        $playlists = Playlist::all();
        $albums = Album::all();
        return view('song.edit', compact('authors', 'playlists', 'song', 'albums'));
    }

    public function update(Request $request, Song $song)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'nullable|array',
            'authors.*' => 'nullable|exists:authors,id',
            'playlists' => 'nullable|array',
            'playlists.*' => 'exists:playlists,id',
            'album_id' => 'nullable|exists:albums,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // max 10 MB
            'mp3link' => 'required|mimes:mp3|max:10240', // max 10 MB
            'yt_link' => 'nullable|string|max:255',
            'spotify_link' => 'nullable|string|max:255',
            'lyrics' => 'nullable|string',
            'release_year' => 'nullable|integer'
        ]);


        $coverPath = $song->cover;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/songs/cover', $coverName);
        }
        $mp3linkPath = $song->mp3link;
        if ($request->hasFile('mp3link')) {
            $mp3link = $request->file('mp3link');
            $mp3linkName = time() . '.' . $mp3link->getClientOriginalExtension();
            $mp3linkPath = $mp3link->storeAs('public/songs/mp3', $mp3linkName);
        }

        $song->title = $request->title;
        $song->album_id = $request->album_id;
        $song->cover = $coverPath ? asset('storage/songs/cover/' . basename($coverPath)) : "";
        $song->mp3link = $mp3linkPath ? asset("storage/songs/mp3/" . basename($mp3linkPath)) : "";
        $song->yt_link = $request->yt_link;
        $song->spotify_link = $request->spotify_link;
        $song->lyrics = $request->lyrics;
        $song->release_year = $request->release_year;

        $song->save();
        $song->playlists()->sync($request['playlists']);
        $song->authors()->sync($request['authors']);
        return redirect()->route('song.index');

    }
    public function destroy(Song $song)
    {
        $song->playlists()->detach();
        $song->authors()->detach();
        $song->delete();
        return redirect()->route('song.index');
    }
    public function restore($id)
    {
        $song = Song::onlyTrashed()->findOrFail($id);
        $song->restore();

        return redirect()->route('song.index')->with('success', 'Song restored successfully.');
    }

}
