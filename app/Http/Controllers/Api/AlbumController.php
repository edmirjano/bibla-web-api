<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album\Album;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function addNewAlbum(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'songs' => 'nullable|array',
                'songs.*' => 'exists:songs,id'
            ]);

            // Create the album
            $album = Album::create([
                'title' => $request->title,
                'user_id' => auth()->user()->id,
                "is_from_admin" => false
            ]);

            // Attach songs if they are provided
            if (!empty($request->songs)) {
                $album->songs()->attach($request->songs);
            }

            return response()->json([
                'success' => true,
                'message' => 'Album created successfully',
                'data' => $album->load('songs')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the album',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    // Get all albums with associated songs
    public function getAlbums(User $user): JsonResponse
    {
        if (auth('sanctum')->check()) {
            $albums = Album::where('user_id', auth('sanctum')->user()->id)
                ->orWhere('is_from_admin', true)
                ->with(['songs.author'])
                ->get();
        } else {
            $albums = Album::where('is_from_admin', true)
                ->with(['songs.author'])
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $albums
        ], 200);
    }

    public function getAlbum(Album $album): JsonResponse
    {
        try {
            $album->load('songs');

            return response()->json([
                'success' => true,
                'data' => $album
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the album',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Update a album by ID
    public function updateAlbum(Request $request, Album $album): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);


            $album->update([
                'title' => $request->title,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Album updated successfully',
                'data' => $album
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the album',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function deleteAlbum(Album $album): JsonResponse
    {
        try {
            $album->delete();

            return response()->json([
                'success' => true,
                'message' => 'Album deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while trying to delete the album',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateSongs(Request $request, Album $album): JsonResponse
    {
        try {
            $request->validate([
                'songs' => 'array',
                'songs.*' => 'exists:songs,id'
            ]);

            $album->songs()->sync($request->songs);

            return response()->json([
                'success' => true,
                'message' => 'Album updated successfully',
                'data' => $album->load('songs')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the album',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function addSongToAlbum(Request $request, Album $album): JsonResponse
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        try {
            $album->songs()->attach($request->song_id);

            return response()->json([
                'success' => true,
                'message' => 'Song added to album successfully.',
                'data' => $album
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the song to the album.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function removeSongFromAlbum(Request $request, Album $album): JsonResponse
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        try {
            $album->songs()->detach($request->song_id);

            return response()->json([
                'success' => true,
                'message' => 'Song removed from album successfully.',
                'data' => $album
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the song from the album.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
