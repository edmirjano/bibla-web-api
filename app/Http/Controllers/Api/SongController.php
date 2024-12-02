<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Song\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function getAllSongs(Request $request): JsonResponse
    {
        try {
            $search = $request->query('search');

            $songs = Song::with('authors')
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('lyrics', 'like', "%{$search}%")
                    ->orWhereHas('authors', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            })
            ->get()
            ->map(function ($song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'mp3link' => $song->mp3link,
                    'cover' => $song->cover,
                    'views' => $song->views,
                    'favorites' => $song->favorites,
                    'created_at' => $song->created_at,
                    'updated_at' => $song->updated_at,
                    'deleted_at' => $song->deleted_at,
                    'yt_link' => $song->yt_link,
                    'spotify_link' => $song->spotify_link,
                    'lyrics' => $song->lyrics,
                    'release_year' => $song->release_year,
                    'author' => $song->authors->first() ? [
                        'id' => $song->authors->first()->id,
                        'name' => $song->authors->first()->name,
                        'cover' => $song->authors->first()->cover,
                        'created_at' => $song->authors->first()->created_at,
                        'updated_at' => $song->authors->first()->updated_at,
                        'bio' => $song->authors->first()->bio,
                    ] : null,
                ];
            });
        
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
                'data' => $song->load('authors') // Load the associated author
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
