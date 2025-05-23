<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidKeywordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('bid_keywords')->insert([
        ['pattern' => 'invitation to bid', 'type' => 'initial', 'active' => true],
        ['pattern' => 'request for proposal', 'type' => 'initial', 'active' => true],
        ['pattern' => 'tender submission', 'type' => 'initial', 'active' => true],
        ['pattern' => 'clarification on bid', 'type' => 'follow-up', 'active' => true],
        ['pattern' => 'contract award', 'type' => 'contract', 'active' => true],
        ['pattern' => 'bid withdrawal', 'type' => 'follow-up', 'active' => true],
    ]);
}
}
