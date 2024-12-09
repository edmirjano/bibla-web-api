<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class GoogleLoginController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = User::create(['name' => $googleUser->name, 'email' => $googleUser->email, 'password' => Hash::make(rand(100000,999999))]);
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function handleGoogleApiCallback(Request $request)
    {
        Log::info("message",$request->all());
        $idToken = $request->input('token');
        Log::info('id',[$idToken]);
        if (!$idToken) {
            return response()->json(['error' => 'Token is required'], 400);
        }

        try {
            // Verify the token with Google
            $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $idToken,
            ]);
            Log::info('res',[$response]);
            if ($response->failed()) {
                return response()->json(['error' => 'Invalid ID token'], 400);
            }

            $googleUser = $response->json();
            Log::info("google user",[$googleUser]);
            // Validate required fields
            if (!isset($googleUser['email']) || !isset($googleUser['sub'])) {
                return response()->json(['error' => 'Invalid Google user data'], 400);
            }

            // Find or create the user
            $user = User::updateOrCreate(
                ['email' => $googleUser['email']],
                [
                    'name' => $googleUser['name'] ?? '',
                    'google_id' => $googleUser['sub'],
                    'avatar' => $googleUser['picture'] ?? '',
                    'password' => Hash::make(rand(100000,999999))
                ]
            );

            // Generate a token for the user
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        } catch (\Exception $e) {
            Log::error("message",[$e]);
            return response()->json(['error' => 'An error occurred while processing the token'], 500);
        }
    }


}
