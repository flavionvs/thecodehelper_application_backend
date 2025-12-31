<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => false,
            'message' => 'ServiceController not implemented',
        ], 501);
    }

    public function create()
    {
        return $this->index();
    }

    public function store(Request $request)
    {
        return $this->index();
    }

    public function show($id)
    {
        return $this->index();
    }

    public function edit($id)
    {
        return $this->index();
    }

    public function update(Request $request, $id)
    {
        return $this->index();
    }

    public function destroy($id)
    {
        return $this->index();
    }
}
