<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('author.index', compact('authors'));
    }

    public function create()
    {
        return view('author.edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/authors', $coverName);
            $coverPath = str_replace('public/', 'storage/', $coverPath);
        }

        Author::create([
            'name' => $request->input('name'),
            'cover' => $coverPath ?? null,
        ]);

        return redirect()->route('author.index')->with('success', 'Author created successfully.');
    }
    
    public function edit(Author $author)
    {
        return view('author.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            if ($author->cover) {
                Storage::disk('public')->delete($author->cover);
            }

            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/authors', $coverName);
            $coverPath = str_replace('public/', 'storage/', $coverPath);
        }

        $author->update([
            'name' => $request->input('name'),
            'cover' => $coverPath ?? $author->cover,
        ]);

        return redirect()->route('author.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('author.index');
    }

    public function getAuthors()
    {
        $authors = Author::all();
        return response()->json($authors);
    }
}
