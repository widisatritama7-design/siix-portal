<?php

namespace App\Helpers;

use App\Models\DCC\Submission;
use Illuminate\Support\Facades\Auth;

class InboxHelper
{
    public static function getWaitingReceiveCount()
    {
        // Need BOTH permissions to see badge counts
        if (Auth::check() && Auth::user()->can('view inbox') && Auth::user()->can('view inbox dcc')) {
            return Submission::where('status', 'Waiting Received')->count();
        }
        return 0;
    }

    public static function getWaitingDistributeCount()
    {
        // Need BOTH permissions to see badge counts
        if (Auth::check() && Auth::user()->can('view inbox') && Auth::user()->can('view inbox dcc')) {
            return Submission::where('status_distribute', 'Waiting Distribute')
                ->where('status', 'Received')
                ->count();
        }
        return 0;
    }

    public static function getTotalInboxCount()
    {
        return self::getWaitingReceiveCount() + self::getWaitingDistributeCount();
    }
}