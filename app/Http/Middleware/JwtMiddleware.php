<?php
namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {       
        try {
            JWTAuth::parseToken()->authenticate();
            if(!auth()->guard(guardName())->user()){
                return response()->json(['status' => false, 'message' => 'Please login first!']);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
                return response()->json(['status' => 'Token Black listed']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}