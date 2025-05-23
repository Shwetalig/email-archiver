<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmailMockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('emails')->insert([
        [
            'message_id' => Str::uuid(),
            'thread_id' => Str::uuid(),
            'from_email' => 'contractor1@example.com',
            'to_emails' => json_encode(['procurement@example.com']),
            'cc_emails' => null,
            'bcc_emails' => null,
            'subject' => 'Invitation to Bid for Construction of Roadway',
            'body_text' => 'You are invited to submit a bid for the Roadway Project. Attached is the bid document.',
            'body_html' => '<p>You are invited to submit a bid for the Roadway Project.</p>',
            'headers' => null,
            'received_at' => Carbon::now()->subDays(6),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'message_id' => Str::uuid(),
            'thread_id' => Str::uuid(),
            'from_email' => 'contractor2@example.com',
            'to_emails' => json_encode(['procurement@example.com']),
            'cc_emails' => null,
            'bcc_emails' => null,
            'subject' => 'Clarification on Bid Submission Date',
            'body_text' => 'Please note the new deadline for the bid submission is June 25th.',
            'body_html' => '<p>Please note the new deadline is June 25th.</p>',
            'headers' => null,
            'received_at' => Carbon::now()->subDays(5),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'message_id' => Str::uuid(),
            'thread_id' => Str::uuid(),
            'from_email' => 'projectteam@example.com',
            'to_emails' => json_encode(['procurement@example.com']),
            'cc_emails' => null,
            'bcc_emails' => null,
            'subject' => 'Contract Award Notification – Bridge Repair',
            'body_text' => 'We are pleased to award the contract to your firm.',
            'body_html' => '<p>We are pleased to award the contract to your firm.</p>',
            'headers' => null,
            'received_at' => Carbon::now()->subDays(4),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'message_id' => Str::uuid(),
            'thread_id' => Str::uuid(),
            'from_email' => 'teamlead@example.com',
            'to_emails' => json_encode(['procurement@example.com']),
            'cc_emails' => null,
            'bcc_emails' => null,
            'subject' => 'Meeting Schedule Update',
            'body_text' => 'Rescheduled project meeting for next week.',
            'body_html' => '<p>Rescheduled project meeting for next week.</p>',
            'headers' => null,
            'received_at' => Carbon::now()->subDays(3),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'message_id' => Str::uuid(),
            'thread_id' => Str::uuid(),
            'from_email' => 'electrics@example.com',
            'to_emails' => json_encode(['procurement@example.com']),
            'cc_emails' => null,
            'bcc_emails' => null,
            'subject' => 'Request for Proposal (RFP): Electrical Work',
            'body_text' => 'Attached is the RFP for electrical maintenance.',
            'body_html' => '<p>Attached is the RFP for electrical maintenance.</p>',
            'headers' => null,
            'received_at' => Carbon::now()->subDays(2),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'message_id' => Str::uuid(),
            'thread_id' => Str::uuid(),
            'from_email' => 'contractor3@example.com',
            'to_emails' => json_encode(['procurement@example.com']),
            'cc_emails' => null,
            'bcc_emails' => null,
            'subject' => 'Bid Withdrawal Notice',
            'body_text' => 'We wish to withdraw our bid for the pipeline project.',
            'body_html' => '<p>We wish to withdraw our bid for the pipeline project.</p>',
            'headers' => null,
            'received_at' => Carbon::now()->subDays(1),
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}
}
