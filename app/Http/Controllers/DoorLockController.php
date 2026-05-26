<?php

namespace App\Http\Controllers;

use App\Services\TuyaDoorLockService;

class DoorLockController extends Controller
{
    public function generatePin(string $deviceId, TuyaDoorLockService $tuya)
    {
        /**
         * STEP 1: GET TICKET
         */
        $ticketResponse = $tuya->createPasswordTicket($deviceId);

        if (!($ticketResponse['success'] ?? false)) {
            return response()->json([
                'step' => 'ticket',
                'error' => 'Failed to create ticket',
                'tuya_response' => $ticketResponse
            ], 500);
        }

        if (!isset($ticketResponse['result'])) {
            return response()->json([
                'step' => 'ticket',
                'error' => 'Missing result from ticket',
                'tuya_response' => $ticketResponse
            ], 500);
        }

        $ticket = $ticketResponse['result'];

        /**
         * STEP 2: CREATE TEMP PASSWORD
         */
        $start = time();
        $end = time() + 3600;

        $passwordResponse = $tuya->createTempPassword(
            $deviceId,
            $ticket,
            $start,
            $end,
            'Guest Access'
        );

        if (!($passwordResponse['success'] ?? false)) {
            return response()->json([
                'step' => 'temp-password',
                'error' => 'Failed to create password',
                'tuya_response' => $passwordResponse
            ], 500);
        }

        return response()->json([
            'success' => true,
            'device_id' => $deviceId,
            'ticket' => $ticket,
            'password_result' => $passwordResponse['result'] ?? null
        ]);
    }
}