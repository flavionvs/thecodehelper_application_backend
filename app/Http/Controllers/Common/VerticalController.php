<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerticalController extends Controller
{
    // Temporary placeholder controller to prevent route resolution failures.
    // Replace with real logic later or remove the related routes if unused.

    public function index(Request $request)
    {
        return response()->json([
            'status' => false,
            'message' => 'VerticalController not implemented',
        ], 501);
    }
}
