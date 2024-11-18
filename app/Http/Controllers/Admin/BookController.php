<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Category\Category;
use App\Models\Group\Group;
use App\Models\Question\Question;
use Dotenv\Repository\Adapter\ReplacingWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('url', request()->fullUrl());
        $books = Book::all();

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $method = 'POST';
        $route = route('book.store');
        return view('books.edit', compact('categories', 'method', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'exists:categories,id',
            'rating' => 'numeric|max:255'
        ]);
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/books/cover', $coverName);
        } else {
            $coverName = null;
            $coverPath = null;
        }
        $book = new Book();
        $book->name = $request->name;
        $book->cover = $coverPath ? asset('/books/cover/' . basename($coverPath)) : null;;
        $book->slug = $request->slug;
        $book->description = $request->description;
        $book->detailed_info = $request->detailed_info;
        $book->author = $request->author;
        $book->category_id = $request->category_id;
        $book->rating = $request->rating;

        $book->save();
        if (session('url')) {
            return redirect(session('url'));
        }
        return redirect()->route('book.index');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Book $book)
    {
        $book = Book::with('groups.topics.sections.questions')
            ->find($book->id);

        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'exists:categories,id',
            'rating' => 'numeric|max:255'
        ]);

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('public/books/cover', $coverName);
            $coverUrl = $coverPath ? asset('/songs/cover/' . basename($coverPath)) : null;
        } else {
            $coverUrl = $book->cover;
        }
        $book->name = $request->name;
        $book->cover = $coverUrl;
        $book->slug = $request->slug;
        $book->description = $request->description;
        $book->detailed_info = $request->detailed_info;
        $book->author = $request->author;
        $book->category_id = $request->category_id;
        $book->rating = $request->rating;
        $book->update();
        if (session('url')) {
            return redirect(session('url'));
        }
        return redirect()->route('book.index');
    }

    public function destroy(Book $book)
    {
        // Delete the book
        $book->delete();

        // Redirect to the books index page
        return redirect()->route('book.index');
    }
}
