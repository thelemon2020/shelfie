<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LightControls
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!User::query()->first()->userSettings->wled_ip) {
            return new JsonResponse(null, JsonResponse::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
