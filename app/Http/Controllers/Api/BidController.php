<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function index()
    {
        return Bid::with('email')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email_id' => 'required|exists:emails,id',
            'subject' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $bid = Bid::create($validated);
        return response()->json($bid, 201);
    }

    public function show(Bid $bid)
    {
        return $bid->load('email');
    }

    public function update(Request $request, Bid $bid)
    {
        $bid->update($request->only(['subject', 'description', 'status']));
        return response()->json($bid);
    }

    public function destroy(Bid $bid)
    {
        $bid->delete();
        return response()->json(null, 204);
    }
}
