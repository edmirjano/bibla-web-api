<?php

namespace App\Http\Controllers\Admin;

use App\Models\Song;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::all();
        return view('song.index', compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        session(['previous_url' => url()->previous()]);
        $authorId = $request->input('autho_Id');
        if (isset($authorId)) {
            $authors = [Song::find($authorId)];
            return view('song.edit', compact('authors'));
        }
        $authors = Author::all();
        return view('song.edit', compact('authors'));
    }

    public function store(Request $request)
    {
        //
        dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg',
            'mp3link' => 'nullable|mimes:mp3',
        ]);
        dd($request->all());
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/songs', $coverName);
        } else {
            $coverName = null;
        }
        if ($request->hasFile('mp3link')) {
            $mp3link = $request->file('mp3link');
            $mp3linkName = time() . '.' . $mp3link->getClientOriginalExtension();
            $mp3linkPath = $mp3link->storeAs('public/songs', $mp3linkName);
        } else {
            $mp3linkName = null;
        }
        $song = new Song();
        $song->title = $request->title;
        $song->author_id = $request->author_id;
        $song->cover = isset($coverName) ? 'storage/books/' . $coverName : $coverName;
        $song->mp3link = isset($mp3linkName) ? 'storage/books/' . $mp3linkName : $mp3linkName;
        $song->save();
        if (session('url')) {
            return redirect(session('url'));
        }
        return redirect()->to('song.index');
    }


    public function edit(Song $song)
    {
        session(['previous_url' => url()->previous()]);

        $authors = Author::all();
        return view('song.edit', compact('authors', 'song'));
    }

    public function update(Request $request, Song $song)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
        ]);

        $song->title = $request->title;
        $song->author_id = $request->author_id;
        $song->update();
        $session = session('previous_url');
        session()->forget('previous_url');
        return redirect()->to($session);
    }

    public function addViewer($id)
    {
        $dbSong = Song::find($id);

        if (!$dbSong) {
            return response()->json(['error' => 'Song not found'], 404);
        }

        $dbSong->increment('views');

        // Optionally, reload the instance if you need to return the updated model
        $dbSong->refresh();

        return response()->json($dbSong->views);
    }

    public function addFavorite($id)
    {
        $dbSong = Song::find($id);

        if (!$dbSong) {
            return response()->json(['error' => 'Song not found'], 404);
        }

        $dbSong->increment('favorites');

        // Optionally, reload the instance if you need to return the updated model
        $dbSong->refresh();

        return response()->json($dbSong->favorites);
    }

    public function removeFavorite($id)
    {
        $dbSong = Song::find($id);

        if (!$dbSong) {
            return response()->json(['error' => 'Song not found'], 404);
        }

        $dbSong->decrement('favorites');

        // Optionally, reload the instance if you need to return the updated model
        $dbSong->refresh();

        return response()->json($dbSong->favorites);
    }

    public function destroy(Song $song)
    {
        $song->delete();
        return redirect()->route('song.index');
    }

    //api calls

    public function getSongs()
    {
        $songs = Song::with('author')->get();
        return response()->json($songs);
    }
}
