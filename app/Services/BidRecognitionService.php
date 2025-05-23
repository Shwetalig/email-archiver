<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\BidKeyword;
use App\Models\Email;
use App\Models\Bid;



class BidRecognitionService
{
    /**
     * Analyze an email to detect if it's a bid-related email
     * Returns the type (initial, follow-up, contract) or null if not matched
     */
    public function analyze(Email $email): ?string
    {
        $keywords = BidKeyword::where('active', true)->get();

        foreach ($keywords as $keyword) {
            $pattern = strtolower($keyword->pattern);

            if (
                str_contains(strtolower($email->subject), $pattern) ||
                str_contains(strtolower($email->body_text), $pattern)
            ) {
                return $keyword->type;
            }
        }

        return null;
    }

    public function processEmail(Email $email)
    {
        $type = $this->analyze($email);

        if ($type === 'initial')
        {
            $bid = Bid::firstOrCreate(
                ['email_id' => $email->id],
                [
                    'subject' => $email->subject,
                    'description' => substr($email->body_text, 0, 1000),
                    'status' => 'new',
                ]


            );

            // Attach the email to the bid
            $bid->emails()->syncWithoutDetaching([$email->id]);

            $bid->assignClassifications($bid, $email);
            return $bid;
        }

        if ($type === 'follow-up')
        {
            $bid = Bid::whereHas('emails', function ($query) use ($email) {
                $query->where('thread_id', $email->thread_id);
            })->latest()->first();
            if (!$bid)
            {
                $subjectSnippet = substr($email->subject, 0, 30);
                $bid = Bid::where('subject', 'LIKE', '%' . $subjectSnippet . '%')->latest()->first();
            }
            if ($bid)
            {
                $bid->emails()->syncWithoutDetaching([$email->id]);
                return $bid;
            }
            else {
                \Log::warning("⚠️ No matching bid found for follow-up email ID {$email->id}, Subject: {$email->subject}");
            }
        }

        return null;
    }


    public function linkFollowUpEmail(Email $email): ?Bid
    {
        $existingBid = Bid::whereHas('email', function ($query) use ($email) {
            $query->where('thread_id', $email->thread_id);
        })->first();

        // If no bid found by thread_id, check if the subject matches
        if (!$existingBid && $email->subject) {
            $existingBid = Bid::where('subject', 'LIKE', '%' . $email->subject . '%')->first();
        }

        if ($existingBid) {
            // Link the follow-up email
            if (!$existingBid->emails->contains($email->id)) {
                $existingBid->emails()->attach($email->id);
            }
            return $existingBid;
        }

        return null;
    }




}
