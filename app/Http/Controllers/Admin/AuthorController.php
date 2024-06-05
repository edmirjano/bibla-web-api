<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->save();

        return redirect()->route('author.index');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->name = $request->name;
        $author->update();

        return redirect()->route('author.index');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('author.index');
    }
}
