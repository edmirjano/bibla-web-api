<?php

namespace App\Http\Controllers\Admin;

use App\Models\Song;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
        ]);
        Song::create($request->all());
        $session = session('previous_url');
        session()->forget('previous_url');
        return redirect()->to($session);
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

    public function destroy(Song $song)
    {
        $song->delete();
        return redirect()->route('song.index');
    }

    //api calls

    public function getSongs(){
        $songs = Song::with('author')->get();
        return response()->json($songs);
    }
}
