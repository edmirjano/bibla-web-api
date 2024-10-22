<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Song\Song;
use Illuminate\Http\JsonResponse;

class SongController extends Controller
{
    public function getAllSongs(): JsonResponse
    {
        try {
            $songs = Song::with('author')->get();

            return response()->json([
                'success' => true,
                'data' => $songs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching songs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get a single song by its ID
    public function getSong(Song $song): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $song->load('author') // Load the associated author
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the song',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Add a view to a specific song using model binding
    public function addViewer(Song $song): JsonResponse
    {
        try {
            $song->increment('views');

            return response()->json([
                'success' => true,
                'song' => $song
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding a viewer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Add a song to favorites
    public function addFavorite(Song $song): JsonResponse
    {
        try {
            $song->increment('favorites');

            return response()->json([
                'success' => true,
                'song' => $song
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding to favorites',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Remove a song from favorites
    public function removeFavorite(Song $song): JsonResponse
    {
        try {
            $song->decrement('favorites');

            return response()->json([
                'success' => true,
                'data' => $song->favorites
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing from favorites',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
