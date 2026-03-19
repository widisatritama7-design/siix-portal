<?php
// app/Http/Middleware/TrackUserActivity.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageView;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Track page view
            PageView::create([
                'user_id' => Auth::id(),
                'url' => $request->fullUrl(),
                'page' => $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        return $next($request);
    }
}