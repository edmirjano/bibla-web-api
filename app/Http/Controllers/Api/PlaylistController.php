<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlayList\Playlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'title' => 'required|string|max:255',
            ]);


            $playlist = Playlist::create([
                'title' => $request->title,
                'user_id' => auth()->user()->id, // Use authenticated user's ID
            ]);

            // Return JSON response for success
            return response()->json([
                'success' => true,
                'message' => 'Playlist created successfully',
                'data' => $playlist
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the playlist',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
