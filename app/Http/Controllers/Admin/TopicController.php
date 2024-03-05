<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group\Group;
use App\Models\Book\Book;
use App\Models\Topic\Topic;
use Illuminate\Http\Request;

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
    public function create()
    {
        $books = Book::with('groups')->get();
        return view('topic.edit', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);
        Topic::create($request->all());

        return redirect()->route('topic.index');
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
    public function edit(Topic $topic)
    {
        session(['previous_url' => url()->previous()]);
        $books = Book::with('groups')->get();
        return view('topic.edit', compact('topic', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'group_id' => 'required|exists:groups,id',
        ]);
        $topic->update(['name'=>$request->name,'description'=>$request->description,'group_id'=>$request->group_id]);
        $session=session('previous_url');
        session()->forget('previous_url');
        return redirect()->to($session);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('topic.index');
    }

}
