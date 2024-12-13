<?php

namespace App\Http\Controllers\Api;

use App\Http\AssignUserClassroomService;
use App\Http\Controllers\Controller;
use App\Models\Classroom\Classroom;
use App\Models\User\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function getAllClassrooms(): JsonResponse
    {
        try {
            $classrooms = Classroom::with([
                'book.groups.topics.sections.questions',
                'book.groups.topics',
                'book.groups',
                'book.category'
            ])->get();

            return response()->json([
                'success' => true,
                'data' => $classrooms
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving classrooms.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a single classroom by ID with related models (books, groups, topics).
     */
    public function getClassroom(Classroom $classroom): JsonResponse
    {
        try {
            $classroom->load([
                'book.groups.topics.sections.questions',
                'book.groups.topics.sections.responses',
                'book.groups.topics',
                'book.groups',
                'book.category'
            ]);

            return response()->json([
                'success' => true,
                'data' => $classroom
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Classroom not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the classroom.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get classrooms by user.
     */
    public function getClassroomsByUser(User $user): JsonResponse
    {
        try {
            $classrooms = $user->classrooms()->get();
            return response()->json([
                'success' => true,
                'data' => $classrooms
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving classrooms for this user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created classroom via API.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'book_id' => 'required|exists:books,id'
            ]);

            $classroom = Classroom::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Classroom created successfully',
                'data' => $classroom
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the classroom.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing classroom via API.
     */
    public function update(Request $request, Classroom $classroom): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'book_id' => 'required|exists:books,id'
            ]);

            $classroom->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Classroom updated successfully',
                'data' => $classroom
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Classroom not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the classroom.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a classroom via API.
     */
    public function destroy(Classroom $classroom): JsonResponse
    {
        try {
            $classroom->delete();

            return response()->json([
                'success' => true,
                'message' => 'Classroom deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the classroom.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add a user to the classroom via API.
     */
    public function addUser(Classroom $classroom,Request $request ,AssignUserClassroomService $classroomService): JsonResponse
    {

        $request->validate([
            'email'=>"required|email"
        ]);

        return  $classroomService->execute($classroom,$request->all());
    }

    /**
     * Remove a user from the classroom via API.
     */
    public function removeUser(int $classroomId,int $userId): JsonResponse
    {
        try {

        $classroom = Classroom::findOrFail($classroomId);
        $classroom->removeUser($userId);

            return response()->json([
                'success' => true,
                'message' => 'User removed from classroom successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Classroom not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the user from the classroom.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
