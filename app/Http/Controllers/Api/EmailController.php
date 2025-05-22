<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Email;

class EmailController extends Controller
{
    public function index()
    {
        $emails = Email::with('attachments')->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $emails
        ]);
    }
}
