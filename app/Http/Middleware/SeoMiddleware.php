<?php

namespace App\Http\Middleware;

use App\Services\SeoService;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // $url = $_SERVER['REQUEST_URI'];
        // dd($next,$request,$url);
        seo()->generateSeo($request->path());
        
        return $next($request);
    }
}
