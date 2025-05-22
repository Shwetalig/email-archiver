<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleService;
use App\Models\OAuthToken;

class GoogleController extends Controller
{
    protected $google;

    public function __construct(GoogleService $google)
    {
        $this->google = $google;
    }

    public function login()
    {
        $client = $this->google->getClient();
        return redirect()->away($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $client = $this->google->getClient();
        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return response()->json(['error' => $token['error']], 400);
        }

        OAuthToken::updateOrCreate(
            ['provider' => 'google'],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'],
                'expires_at' => now()->addSeconds($token['expires_in'])
            ]
        );

        return response()->json(['message' => 'Authenticated and token saved!']);
    }
}
