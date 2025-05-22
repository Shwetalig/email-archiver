<?php

namespace App\Services;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Drive;

class GoogleService
{
    public function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        ]);
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope([
    \Google_Service_Gmail::GMAIL_READONLY,
    \Google_Service_Drive::DRIVE_FILE, // this is required for uploading files
]);

        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return $client;
    }
}
