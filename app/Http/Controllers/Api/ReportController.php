<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function bidTypes()
    {
        $types = Bid::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return response()->json($types);
    }

    public function classifications()
    {
        $data = DB::table('bid_classification')
            ->join('classifications', 'bid_classification.classification_id', '=', 'classifications.id')
            ->select('classifications.name', DB::raw('count(*) as total'))
            ->groupBy('classifications.name')
            ->get();

        return response()->json($data);
    }
}
