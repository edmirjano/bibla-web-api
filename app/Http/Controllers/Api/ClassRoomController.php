<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom\Classroom;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassRoomController extends Controller
{
    /**
     * Get all classrooms along with related models (books, groups, topics).
     */
    public function getAllClassrooms(): JsonResponse
    {
        $classrooms = Classroom::with('book')->get();

        return response()->json([
            'success' => true,
            'data' => $classrooms
        ], 200);
    }

    /**
     * Get a single classroom by ID with related models (books, groups, topics).
     */
    public function getClassroom(Classroom $classroom): JsonResponse
    {
        // Eager load the related models (books, groups, topics)
        $classroom->load(['books', 'groups', 'topics']);

        return response()->json([
            'success' => true,
            'data' => $classroom
        ], 200);
    }

    /**
     * Store a newly created classroom via API.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $classroom = Classroom::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Classroom created successfully',
            'data' => $classroom
        ], 201);
    }

    /**
     * Update an existing classroom via API.
     */
    public function update(Request $request, Classroom $classroom): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $classroom->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Classroom updated successfully',
            'data' => $classroom
        ], 200);
    }

    /**
     * Delete a classroom via API.
     */
    public function destroy(Classroom $classroom): JsonResponse
    {
        $classroom->delete();

        return response()->json([
            'success' => true,
            'message' => 'Classroom deleted successfully'
        ], 200);
    }

    /**
     * Add a user to the classroom via API.
     */
    public function addUser($classroomId, $userId): JsonResponse
    {
        $classroom = Classroom::findOrFail($classroomId);
        $classroom->users()->attach($userId);

        return response()->json([
            'success' => true,
            'message' => 'User added to classroom successfully'
        ], 200);
    }

    /**
     * Remove a user from the classroom via API.
     */
    public function removeUser($classroomId, $userId): JsonResponse
    {
        $classroom = Classroom::findOrFail($classroomId);
        $classroom->users()->detach($userId);

        return response()->json([
            'success' => true,
            'message' => 'User removed from classroom successfully'
        ], 200);
    }
}
