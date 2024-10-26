<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function getAuthors(): JsonResponse
    {
        try {
            $authors = Author::all();

            return response()->json([
                'success' => true,
                'data' => $authors
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the authors',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get a single author by ID
    public function getAuthor(Author $author): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $author
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the author',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Update an author by ID
    public function updateAuthor(Request $request, Author $author): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'cover' => 'nullable|string',
            ]);

            $author->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Author updated successfully',
                'data' => $author
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the author',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    // Delete an author by ID
    public function deleteAuthor(Author $author): JsonResponse
    {
        try {
            $author->delete();

            return response()->json([
                'success' => true,
                'message' => 'Author deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while trying to delete the author',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
