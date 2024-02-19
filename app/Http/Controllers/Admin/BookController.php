<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BooksDataTable;
use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'slug' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'detailed_info' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'exists:categories,id',
            'rating' => 'required|numeric|max:255'
        ]);

// Handle file upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '.' . $cover->getClientOriginalExtension();

            // Store the image in the storage/app/public directory
            $coverPath = $cover->storeAs('public/books', $coverName);

            // If you're using symbolic links for storage, generate the URL
            $coverUrl = Storage::disk('public')->url($coverPath);
        } else {
            // Handle case where no cover image is uploaded
            $coverUrl = null;
        }

// Create a new book
        $book = new Book();
        $book->name = $request->name;
        $book->cover = $coverUrl;
        $book->slug = $request->slug;
        $book->description = $request->description;
        $book->detailed_info = $request->detailed_info;
        $book->author = $request->author;
        $book->category_id = $request->category_id;
        $book->rating = $request->rating;

        $book->save();

// Redirect to the books index page
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Book $book)
    {
        // Return the view for editing a book
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            // Add more validation rules as needed
        ]);

        // Update the book
        $book->name = $request->name;
        // Update other properties as needed
        $book->save();

        // Redirect back to the book edit page
        return redirect()->route('books.edit', $book->id);
    }

    public function destroy(Book $book)
    {
        // Delete the book
        $book->delete();

        // Redirect to the books index page
        return redirect()->route('books.index');
    }
}
