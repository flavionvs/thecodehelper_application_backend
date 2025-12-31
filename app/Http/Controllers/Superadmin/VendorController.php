<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // Temporary placeholder to prevent route resolution failures.
    // Replace with real logic later or remove related routes if unused.

    public function index(Request $request)
    {
        return response()->json([
            'status' => false,
            'message' => 'VendorController not implemented',
        ], 501);
    }
}