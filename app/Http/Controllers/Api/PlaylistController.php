<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlayList\Playlist;
use App\Models\User\User;
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
                'user_id' => auth()->user()->id,
            ]);

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

    // Get all playlists with associated songs
    public function getPlaylists(User $user): JsonResponse
    {
        if (auth('sanctum')->check()) {
            $playlists =  Playlist::where('user_id',auth('sanctum')->user()->id)->with('songs')->get();
        } else {
            $playlists = Playlist::with('songs')->get();
        }

        return response()->json([
            'success' => true,
            'data' => $playlists
        ], 200);
    }

    public function getPlaylist(Playlist $playlist): JsonResponse
    {
        try {
            $playlist->load('songs');

            return response()->json([
                'success' => true,
                'data' => $playlist
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the playlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Update a playlist by ID
    public function updatePlaylist(Request $request, Playlist $playlist): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);


            $playlist->update([
                'title' => $request->title,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Playlist updated successfully',
                'data' => $playlist
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the playlist',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function deletePlaylist(Playlist $playlist): JsonResponse
    {
        try {
            $playlist->delete();

            return response()->json([
                'success' => true,
                'message' => 'Playlist deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while trying to delete the playlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateSongs(Request $request, Playlist $playlist): JsonResponse
    {
        try {
            $request->validate([
                'songs' => 'array',
                'songs.*' => 'exists:songs,id'
            ]);

            $playlist->songs()->sync($request->songs);

            return response()->json([
                'success' => true,
                'message' => 'Playlist updated successfully',
                'data' => $playlist->load('songs')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the playlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function addSongToPlaylist(Request $request, Playlist $playlist): JsonResponse
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        try {
            $playlist->songs()->attach($request->song_id);

            return response()->json([
                'success' => true,
                'message' => 'Song added to playlist successfully.',
                'data' => $playlist
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the song to the playlist.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function removeSongFromPlaylist(Request $request, Playlist $playlist): JsonResponse
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        try {
            $playlist->songs()->detach($request->song_id);

            return response()->json([
                'success' => true,
                'message' => 'Song removed from playlist successfully.',
                'data' => $playlist
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the song from the playlist.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
