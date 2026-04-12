<?php
// app/Http/Middleware/TrackUserActivity.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageView;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    /**
     * List of paths to exclude from tracking
     */
    protected $excludePaths = [
        'livewire',
        'livewire/*',
        'livewire/update',
        'livewire/message',
        'livewire/upload-file',
    ];

    /**
     * Check if request should be tracked
     */
    protected function shouldTrack(Request $request): bool
    {
        // Must be authenticated
        if (!Auth::check()) {
            return false;
        }
        
        // Check if path contains livewire
        $path = $request->path();
        if (str_contains($path, 'livewire')) {
            return false;
        }
        
        // Check if URL contains livewire
        if (str_contains($request->fullUrl(), 'livewire')) {
            return false;
        }
        
        // Check for Livewire header
        if ($request->header('X-Livewire')) {
            return false;
        }
        
        return true;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldTrack($request)) {
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