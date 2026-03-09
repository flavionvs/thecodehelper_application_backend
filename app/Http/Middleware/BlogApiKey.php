<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlogApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-Blog-Api-Key');

        if (!$apiKey || !hash_equals((string) config('services.blog_api_key'), $apiKey)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or missing Blog API Key.',
            ], 401);
        }

        return $next($request);
    }
}
