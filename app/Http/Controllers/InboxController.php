<?php

namespace App\Http\Controllers;

use App\Models\DCC\Submission;
use App\Models\Ticket\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hasViewOneUser = $user->can('view tickets one user');
        
        // Get counts for DCC badges
        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();

        // Get counts for Ticket badges
        $waitingApproveCount = Ticket::where('approval', 'Waiting Approval')->count();
        
        // Khusus waiting check dengan filter view tickets one user
        $waitingCheckQuery = Ticket::where('approval_user', 'Waiting Approval');
        if ($hasViewOneUser) {
            $waitingCheckQuery->where('created_by', $user->id);
        }
        $waitingCheckCount = $waitingCheckQuery->count();

        // Get submissions for waiting receive section - Latest 5 items only
        $waitingReceiveSubmissions = Submission::with('department', 'creator')
            ->where('status', 'Waiting Received')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get submissions for waiting distribute section - Latest 5 items only
        $waitingDistributeSubmissions = Submission::with('department', 'creator')
            ->where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get tickets for waiting approve section - Latest 5 items only (semua, tanpa filter)
        $waitingApproveTickets = Ticket::with('category', 'creator')
            ->where('approval', 'Waiting Approval')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get tickets for waiting check section - Latest 5 items only dengan filter
        $waitingCheckQuery = Ticket::with('category', 'creator')
            ->where('approval_user', 'Waiting Approval');
        
        if ($hasViewOneUser) {
            $waitingCheckQuery->where('created_by', $user->id);
        }
        
        $waitingCheckTickets = $waitingCheckQuery
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home.inbox.index', [
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount,
            'waitingReceiveSubmissions' => $waitingReceiveSubmissions,
            'waitingDistributeSubmissions' => $waitingDistributeSubmissions,
            'waitingApproveCount' => $waitingApproveCount,
            'waitingCheckCount' => $waitingCheckCount,
            'waitingApproveTickets' => $waitingApproveTickets,
            'waitingCheckTickets' => $waitingCheckTickets,
        ]);
    }

    // DCC Methods
    public function waitingReceive()
    {
        $submissions = Submission::with('department', 'creator')
            ->where('status', 'Waiting Received')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();
        
        $user = Auth::user();
        $hasViewOneUser = $user->can('view tickets one user');
        
        $waitingApproveCount = Ticket::where('approval', 'Waiting Approval')->count();
        
        // Khusus waiting check dengan filter
        $waitingCheckQuery = Ticket::where('approval_user', 'Waiting Approval');
        if ($hasViewOneUser) {
            $waitingCheckQuery->where('created_by', $user->id);
        }
        $waitingCheckCount = $waitingCheckQuery->count();

        return view('home.inbox.dcc.waiting-receive', [
            'submissions' => $submissions,
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount,
            'waitingApproveCount' => $waitingApproveCount,
            'waitingCheckCount' => $waitingCheckCount,
        ]);
    }

    public function receive($id)
    {
        $submission = Submission::findOrFail($id);
        
        $submission->status = 'Received';
        $submission->received_by = auth()->user()->name;
        $submission->received_at = now();
        $submission->save();

        return redirect()->back()->with('success', 'Submission has been received successfully.');
    }

    public function waitingDistribute()
    {
        $submissions = Submission::with('department', 'creator')
            ->where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();
        
        $user = Auth::user();
        $hasViewOneUser = $user->can('view tickets one user');
        
        $waitingApproveCount = Ticket::where('approval', 'Waiting Approval')->count();
        
        // Khusus waiting check dengan filter
        $waitingCheckQuery = Ticket::where('approval_user', 'Waiting Approval');
        if ($hasViewOneUser) {
            $waitingCheckQuery->where('created_by', $user->id);
        }
        $waitingCheckCount = $waitingCheckQuery->count();

        return view('home.inbox.dcc.waiting-distribute', [
            'submissions' => $submissions,
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount,
            'waitingApproveCount' => $waitingApproveCount,
            'waitingCheckCount' => $waitingCheckCount,
        ]);
    }

    public function getSubmission($id)
    {
        $submission = Submission::with('department', 'creator')->findOrFail($id);
        return response()->json($submission);
    }

    public function distribute(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        
        $submission->status = 'Completed';
        $submission->status_distribute = 'Distributed';
        $submission->distributed_at = now();
        $submission->distributed_by = auth()->user()->name;
        $submission->save();

        return response()->json([
            'success' => true,
            'message' => 'Submission has been marked as distributed successfully.'
        ]);
    }

    // Ticket Methods
    public function waitingApprove()
    {
        // Waiting approve: semua tickets, tanpa filter
        $tickets = Ticket::with('category', 'creator')
            ->where('approval', 'Waiting Approval')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $waitingApproveCount = Ticket::where('approval', 'Waiting Approval')->count();
        
        $user = Auth::user();
        $hasViewOneUser = $user->can('view tickets one user');
        
        // Khusus waiting check dengan filter
        $waitingCheckQuery = Ticket::where('approval_user', 'Waiting Approval');
        if ($hasViewOneUser) {
            $waitingCheckQuery->where('created_by', $user->id);
        }
        $waitingCheckCount = $waitingCheckQuery->count();
        
        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();

        return view('home.inbox.ticket.waiting-approve', [
            'tickets' => $tickets,
            'waitingApproveCount' => $waitingApproveCount,
            'waitingCheckCount' => $waitingCheckCount,
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount,
        ]);
    }

    public function waitingCheck()
    {
        $user = Auth::user();
        $hasViewOneUser = $user->can('view tickets one user');
        
        // Waiting check: dengan filter view tickets one user
        $tickets = Ticket::with('category', 'creator')
            ->where('approval_user', 'Waiting Approval');
        
        if ($hasViewOneUser) {
            $tickets->where('created_by', $user->id);
        }
        
        $tickets = $tickets->orderBy('created_at', 'desc')
            ->paginate(10);

        $waitingApproveCount = Ticket::where('approval', 'Waiting Approval')->count();
        
        // Khusus waiting check dengan filter untuk count
        $waitingCheckQuery = Ticket::where('approval_user', 'Waiting Approval');
        if ($hasViewOneUser) {
            $waitingCheckQuery->where('created_by', $user->id);
        }
        $waitingCheckCount = $waitingCheckQuery->count();
        
        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();

        return view('home.inbox.ticket.waiting-check', [
            'tickets' => $tickets,
            'waitingApproveCount' => $waitingApproveCount,
            'waitingCheckCount' => $waitingCheckCount,
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount,
        ]);
    }

    public function getTicket($id)
    {
        $ticket = Ticket::with('category', 'creator')->findOrFail($id);
        return response()->json($ticket);
    }
}