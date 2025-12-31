<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiProposalController extends Controller
{
    public function storePreInitiation(Request $request)
    {
        return response()->json([
            'status' => false,
            'message' => 'Not implemented',
        ], 501);
    }

    public function storePostInitiation(Request $request)
    {
        return response()->json([
            'status' => false,
            'message' => 'Not implemented',
        ], 501);
    }

    public function proposalDetails($pre_or_post, $proposal_id)
    {
        return response()->json([
            'status' => false,
            'message' => 'Not implemented',
        ], 501);
    }

    public function proposalBeneficiaries($pre_or_post, $proposal_id)
    {
        return response()->json([
            'status' => false,
            'message' => 'Not implemented',
        ], 501);
    }
}
