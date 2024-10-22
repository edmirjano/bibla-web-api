<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author\Author;
use App\Models\Song\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg',
            'mp3link' => 'nullable|mimes:mp3',
        ]);

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
        } else {
            $mp3linkPath = null;
        }

        // Create a new Song instance
        $song = new Song();
        $song->title = $request->title;
        $song->author_id = $request->author_id;
        $song->cover = $coverPath ? asset('/songs/cover/' . basename($coverPath)) : null;
        $song->mp3link = $mp3linkPath ?  asset("songs/mp3/" . basename($mp3linkPath)) : null;
        $song->save();

        return redirect()->back();
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
            'cover' => 'nullable|image|mimes:jpeg,png,jpg',
            'mp3link' => 'nullable|mimes:mp3',
        ]);
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/songs/cover', $coverName);
        }

        // Handle the mp3 file
        $mp3linkPath = null;
        if ($request->hasFile('mp3link')) {
            $mp3link = $request->file('mp3link');
            $mp3linkName = time() . '.' . $mp3link->getClientOriginalExtension();
            $mp3linkPath = $mp3link->storeAs('public/songs/mp3', $mp3linkName);
        }


        $song = new Song();
        $song->title = $request->title;
        $song->author_id = $request->author_id;
        $song->cover = $coverPath ? asset('/songs/cover/' . basename($coverPath)) : null;
        $song->mp3link = $mp3linkPath ?  asset("songs/mp3/" . basename($mp3linkPath)) : null;
        $song->save();
    }
    public function destroy(Song $song)
    {
        $song->delete();
        return redirect()->route('song.index');
    }

}
