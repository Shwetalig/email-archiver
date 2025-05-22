<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OAuthToken;
use App\Models\Email;
use Google_Client;
use Google_Service_Gmail;
use Carbon\Carbon;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use App\Models\Attachment;
use Illuminate\Support\Str;

class FetchGmailEmails extends Command
{
    protected $signature = 'fetch:emails';
    protected $description = 'Fetch recent emails from Gmail using OAuth';

    public function handle()
    {
        $token = OAuthToken::where('provider', 'gmail')->first();

        if (!$token) {
            $this->error('No OAuth token found.');
            return;
        }

        $client = new Google_Client();
        $client->setAuthConfig([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        ]);
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');
        $client->addScope([
            Google_Service_Gmail::GMAIL_READONLY,
            Google_Service_Drive::DRIVE_FILE
        ]);


        $client->setAccessToken([
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token,
            'expires_in' => $token->expires_at ? $token->expires_at->diffInSeconds(now()) : 3600,
            'created' => strtotime($token->created_at),
        ]);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            $newToken = $client->getAccessToken();
            $token->update([
                'access_token' => $newToken['access_token'],
                'expires_at' => now()->addSeconds($newToken['expires_in']),
            ]);

            $this->info('Token refreshed and updated.');
        }

        $service = new Google_Service_Gmail($client);
        $messages = $service->users_messages->listUsersMessages('me', [
            'maxResults' => 10,
            'q' => 'newer_than:1d',
        ]);

        if (count($messages->getMessages()) === 0) {
            $this->info('No new messages found.');
            return;
        }

        foreach ($messages->getMessages() as $message) {
            $msg = $service->users_messages->get('me', $message->getId(), ['format' => 'full']);
            $payload = $msg->getPayload();
            $headers = $payload->getHeaders();

            // Default values
            $subject = $from = $messageId = $threadId = '';
            $to = $cc = $bcc = [];
            $bodyText = $bodyHtml = null;
            $receivedAt = now();
            $headerArray = [];

            // Extract header info
            foreach ($headers as $header) {
                $name = $header->getName();
                $value = $header->getValue();

                $headerArray[$name] = $value;

                switch ($name) {
                    case 'Subject':
                        $subject = $value;
                        break;
                    case 'From':
                        $from = $value;
                        break;
                    case 'To':
                        $to = explode(',', $value);
                        break;
                    case 'Cc':
                        $cc = explode(',', $value);
                        break;
                    case 'Bcc':
                        $bcc = explode(',', $value);
                        break;
                    case 'Date':
                        $receivedAt = Carbon::parse($value);
                        break;
                }
            }

            $messageId = $msg->getId();
            $threadId = $msg->getThreadId();

            // Extract body
            $parts = $payload->getParts();
            if ($parts) {
                foreach ($parts as $part) {
                    $mimeType = $part->getMimeType();
                    $data = $part->getBody()->getData();
                    if ($data) {
                        $decoded = base64_decode(strtr($data, '-_', '+/'));
                        if ($mimeType === 'text/plain') {
                            $bodyText = $decoded;
                        } elseif ($mimeType === 'text/html') {
                            $bodyHtml = $decoded;
                        }
                    }
                }
            } else {
                $data = $payload->getBody()->getData();
                if ($data) {
                    $bodyText = base64_decode(strtr($data, '-_', '+/'));
                }
            }

            // Save to DB
            Email::updateOrCreate(
                ['message_id' => $messageId],
                [
                    'thread_id' => $threadId,
                    'from_email' => $from,
                    'to_emails' => $to,
                    'cc_emails' => $cc,
                    'bcc_emails' => $bcc,
                    'subject' => $subject,
                    'body_text' => $bodyText,
                    'body_html' => $bodyHtml,
                    'headers' => $headerArray,
                    'received_at' => $receivedAt,
                ]
            );

            $this->info("Stored email: $subject | From: $from");

            $driveService = new Google_Service_Drive($client);
            $emailRecord = Email::where('message_id', $messageId)->first();

            if ($parts) {
                foreach ($parts as $part) {
                    // Skip if no filename
                    if ($part->getFilename() && $part->getBody()->getAttachmentId()) {
                        $attachmentId = $part->getBody()->getAttachmentId();
                        $attachment = $service->users_messages_attachments->get('me', $messageId, $attachmentId);
                        $data = base64_decode(strtr($attachment->getData(), '-_', '+/'));

                        // Temp file
                        $fileName = $part->getFilename();
                        $tempPath = storage_path('app/temp_' . Str::random(10) . '_' . $fileName);
                        file_put_contents($tempPath, $data);

                        // Upload to Drive
                        $driveFile = new Google_Service_Drive_DriveFile();
                        $driveFile->setName($fileName);
                        $driveFile->setParents([env('GOOGLE_DRIVE_FOLDER_ID')]);

                        $uploadedFile = $driveService->files->create($driveFile, [
                            'data' => file_get_contents($tempPath),
                            'mimeType' => $part->getMimeType(),
                            'uploadType' => 'multipart',
                            'fields' => 'id, webViewLink'
                        ]);

                        // Clean up temp file
                        unlink($tempPath);

                        // Save attachment record
                        Attachment::create([
                            'email_id' => $emailRecord->id,
                            'filename' => $fileName,
                            'drive_file_id' => $uploadedFile->id,
                            'drive_file_link' => $uploadedFile->webViewLink,
                        ]);

                        $this->info("📎 Uploaded and saved attachment: $fileName");
                    }
                }
            }
        }
    }
}
