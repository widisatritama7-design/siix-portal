<?php

namespace App\Http\Controllers\DCC;

use App\Models\DCC\Submission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $waitingReceive = Submission::where('status', 'Waiting Received')->count();

        $waitingDistribute = Submission::where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->count();

        return view('home.inbox.index', compact(
            'waitingReceive',
            'waitingDistribute'
        ));
    }

    public function waitingReceive()
    {
        $submissions = Submission::with('department', 'creator')
            ->where('status', 'Waiting Received')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('home.inbox.dcc.waiting-receive', compact('submissions'));
    }

    public function receive($id)
    {
        $submission = Submission::findOrFail($id);
        
        $submission->status = 'Received';
        $submission->received_by = auth()->id();
        $submission->save();

        return redirect()->back()->with('success', 'Submission has been received successfully.');
    }

    public function waitingDistribute()
    {
        $submissions = Submission::with('department', 'creator')
            ->where('status_distribute', 'Waiting Distribute')
            ->where('status', 'Received')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('home.inbox.dcc.waiting-distribute', compact('submissions'));
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
        $submission->save();

        return response()->json([
            'success' => true,
            'message' => 'Submission has been marked as distributed successfully.'
        ]);
    }
}