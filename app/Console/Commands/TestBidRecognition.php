<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email;
use App\Services\BidRecognitionService;

class TestBidRecognition extends Command
{
    protected $signature = 'test:bid-recognition';
    protected $description = 'Test bid recognition: create or link bids based on email content';

    public function handle()
    {
        $service = new BidRecognitionService();
        $emails = Email::all();

        foreach ($emails as $email) {
            $this->info("Subject: {$email->subject}");
            $type = $service->analyze($email);
            $this->line("Detected Type: " . ($type ?? 'Not a bid-related email'));

            if ($type === 'initial') {
                $bid = $service->processEmail($email);
                if ($bid->wasRecentlyCreated ?? false) {
                    $this->info("✅ Bid created: ID {$bid->id}, Status: {$bid->status}");
                } else {
                    $this->warn("⚠️ Bid already exists for this email.");
                }

            } elseif ($type === 'follow-up') {
                $linkedBid = $service->linkFollowUpEmail($email);
                if ($linkedBid) {
                    $this->info("🔗 Follow-up email linked to Bid ID {$linkedBid->id}");
                } else {
                    $this->warn("⚠️ No matching bid found to link this follow-up email.");
                }
            }

            $this->line(str_repeat('-', 50));
        }
    }
}
