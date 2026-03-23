<?php

namespace App\Http\Controllers;

use App\Models\DCC\Submission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        // Get counts for badges
        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();

        // Get submissions for waiting receive section (paginated)
        $waitingReceiveSubmissions = Submission::with('department', 'creator')
            ->where('status', 'Waiting Received')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get submissions for waiting distribute section (paginated)
        $waitingDistributeSubmissions = Submission::with('department', 'creator')
            ->where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Debug: Check what data is being retrieved
        \Log::info('Inbox Index - Data:', [
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount,
            'waitingReceiveSubmissions_count' => $waitingReceiveSubmissions->total(),
            'waitingDistributeSubmissions_count' => $waitingDistributeSubmissions->total(),
            'waitingReceiveSubmissions_data' => $waitingReceiveSubmissions->items()
        ]);

        return view('home.inbox.index', [
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount,
            'waitingReceiveSubmissions' => $waitingReceiveSubmissions,
            'waitingDistributeSubmissions' => $waitingDistributeSubmissions
        ]);
    }

    public function waitingReceive()
    {
        $submissions = Submission::with('department', 'creator')
            ->where('status', 'Waiting Received')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get counts for badges
        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();

        return view('home.inbox.dcc.waiting-receive', [
            'submissions' => $submissions,
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount
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

        // Get counts for badges
        $waitingReceiveCount = Submission::where('status', 'Waiting Received')->count();
        $waitingDistributeCount = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();

        return view('home.inbox.dcc.waiting-distribute', [
            'submissions' => $submissions,
            'waitingReceiveCount' => $waitingReceiveCount,
            'waitingDistributeCount' => $waitingDistributeCount
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
}