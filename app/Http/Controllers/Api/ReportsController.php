<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function bidsByClassification()
    {
        $data = Classification::withCount('bids')->get()
            ->groupBy('type')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'bid_count' => $item->bids_count,
                    ];
                });
            });

        return response()->json($data);
    }

    public function bidsByStatus()
{
    $data = \App\Models\Bid::select('status')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('status')
        ->get();

    return response()->json($data);
}

public function bidsTimeline()
{
    $data = \App\Models\Bid::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupByRaw('DATE(created_at)')
        ->orderBy('date', 'asc')
        ->get();

    return response()->json($data);
}



}
