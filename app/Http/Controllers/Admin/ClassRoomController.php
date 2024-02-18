<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom\Classroom;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::all();
        return view('classroom.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classroom.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Classroom::create($validatedData);

        return redirect()->route('classroom.index')->with('success', 'Classroom created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classroom::findOrFail($id);
        $users = User::whereNotIn('id', $classroom->users->pluck('id'))->get();
        return view('classroom.edit', compact('classroom', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'new_user_ids.*' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->only('name', 'description'));

        if ($request->filled('new_user_ids')) {
            $classroom->users()->attach($request->input('new_user_ids'));
        }

        return redirect()->route('classroom.index')->with('success', 'Classroom updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Classroom::findOrFail($id)->delete();
        return redirect()->route('classroom.index')->with('success', 'Classroom deleted successfully');
    }

    /**
     * Add a user to the classroom.
     */
    public function addUser($classroomId, $userId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $classroom->addUser($userId);
        return redirect()->back()->with('success', 'User added successfully to the classroom.');
    }

    /**
     * Remove a user from the classroom.
     */
    public function removeUser($classroomId, $userId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $classroom->removeUser($userId);
        return redirect()->back()->with('success', 'User removed successfully from the classroom.');
    }
}
