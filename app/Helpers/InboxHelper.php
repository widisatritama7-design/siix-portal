<?php

namespace App\Helpers;

use App\Models\DCC\Submission;
use App\Models\Ticket\Ticket;
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

    public static function getWaitingApproveCount()
    {
        // Need approve tickets permission
        if (Auth::check() && Auth::user()->can('approve tickets')) {
            return Ticket::where('approval', 'Waiting Approval')->count();
        }
        return 0;
    }

    public static function getWaitingCheckCount()
    {
        // Need check tickets permission
        if (Auth::check() && Auth::user()->can('check tickets')) {
            $user = Auth::user();
            $hasViewOneUser = $user->can('view tickets one user');
            
            $query = Ticket::where('approval_user', 'Waiting Approval');
            
            // Jika user memiliki view tickets one user, filter berdasarkan created_by
            if ($hasViewOneUser) {
                $query->where('created_by', $user->id);
            }
            
            return $query->count();
        }
        return 0;
    }

    public static function getTotalInboxCount()
    {
        return self::getWaitingReceiveCount() + 
               self::getWaitingDistributeCount() + 
               self::getWaitingApproveCount() + 
               self::getWaitingCheckCount();
    }
}