<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Classroom\Classroom;
use App\Models\Group\Group;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books=Book::all();
        return view('groups.edit',compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
           'book_id'=>'required'
        ]);
       $newGroup=new Group();
       $newGroup->name=$request->name;
       $newGroup->book_id=$request->book_id;
       $newGroup->save();
        return redirect()->route('group.index');

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
    public function edit(Group $group)
    {
        $books=Book::all();
        return view('groups.edit', compact('group','books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'book_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $group->update($request->only('name', 'book_id'));
        return redirect()->route('group.index')->with('success', 'Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();

        // Redirect to the books index page
        return redirect()->route('groups.index');
    }
}
