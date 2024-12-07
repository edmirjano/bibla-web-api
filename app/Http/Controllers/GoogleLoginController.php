<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

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
    public function handleGoogleApiCallback()
    {

        try {
            // Attempt to retrieve the Google user information
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Validate required fields from Google
            if (!$googleUser->getEmail()) {
                return response()->json(['error' => 'Email not provided by Google.'], 400);
            }

            if (!$googleUser->getId()) {
                return response()->json(['error' => 'Google ID not provided.'], 400);
            }

            // Find or create the user
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]
            );

            // Generate a token for the user
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);

        } catch (\Exception $e) {
            // General error handling
            return response()->json(['error' => 'An error occurred while authenticating.'], 500);
        }
    }


}
