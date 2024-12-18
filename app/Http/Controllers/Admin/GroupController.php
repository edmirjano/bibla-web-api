<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Classroom\Classroom;
use App\Models\Group\Group;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();

        return view('groups.index', compact('groups'));
    }

    public function show(int $bookId)
    {
        Session::put('url',request()->fullUrl());

        $groups = Group::where('book_id', $bookId)->get();
        $book = Book::find($bookId);

        return view('books.bookGroups', compact('groups', 'book'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        if ($request->filled('book_id')) {
            $request->validate([
                'book_id' => 'required|numeric'
            ]);
            $book = Book::find($request->book_id);
            return view('groups.edit', compact('book'));
        }
        $books = Book::all();
        return view('groups.edit', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'book_id' => 'exists:books,id',
            'description' => 'nullable|string',
        ]);
        $bookId = $request->book_id;
        $newGroup = new Group();
        $newGroup->name = $request->name;
        $newGroup->book_id = $bookId;
        $newGroup->description = $request->description;
        $newGroup->save();
        $groups = Group::where('book_id', $bookId)->get();
        $book = Book::find($bookId);

        return view('books.bookGroups', compact('groups', 'book'));

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $books = Book::all();
        return view('groups.edit', compact('group', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'book_id' => 'required',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $group->update($request->only('name', 'book_id', 'description'));
        return view('books.bookGroups')->with('success', 'Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();

        // Redirect to the books index page
        return redirect()->back();
    }
}
