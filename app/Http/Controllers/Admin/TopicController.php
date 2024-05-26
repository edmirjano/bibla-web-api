<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group\Group;
use App\Models\Book\Book;
use App\Models\Topic\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::with('group')->get();
        return view('topic.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $groupId = $request->input('groupId');
        $bookId = $request->input('book_    id');
        $groups = Group::all();

        $books = Book::with('groups')->get();

        return view('topic.edit', compact('books', 'groups', 'groupId', 'bookId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);
        
        Topic::create($request->all());
        if(session('url')){
            return redirect(session('url'));
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $groupId)
    {
        Session::put('url',request()->fullUrl());

        $topics = Topic::where('group_id', $groupId)->get();
        return view('topic.index', compact('topics', 'groupId'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        $groups = Group::all();
        $books = Book::with('groups')->get();

        return view('topic.edit', compact('topic', 'books', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);
        $topic->update(['name' => $request->name, 'description' => $request->description, 'group_id' => $request->group_id]);
        if(session('url')){
            return redirect(session('url'));
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->back();
    }

    public function getByBook(int $bookId)
    {
        Session::put('url',request()->fullUrl());

        $book = Book::with('topics')->find($bookId);
        $topics = $book->topics;
        return view('topic.index', compact('topics', 'bookId'));
    }
}
