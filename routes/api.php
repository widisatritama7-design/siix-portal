<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/approval/action', function (Request $request) {

    Log::info('OUTLOOK APPROVAL ACTION', [
        'headers' => $request->headers->all(),
        'body' => $request->all(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Approval berhasil diterima oleh Laravel.',
        'data' => [
            'action' => $request->input('action'),
            'request_id' => $request->input('request_id'),
            'comment' => $request->input('comment'),
        ],
    ]);
});