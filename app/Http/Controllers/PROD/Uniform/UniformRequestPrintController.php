<?php

namespace App\Http\Controllers\PROD\Uniform;

use App\Http\Controllers\Controller;
use App\Models\PROD\Uniform\UniformRequest;
use App\Models\HR\Employee;
use App\Models\PROD\Uniform\MasterUniform;
use Barryvdh\DomPDF\Facade\Pdf;

class UniformRequestPrintController extends Controller
{
    public function print($id)
    {
        $request = UniformRequest::with('creator')->findOrFail($id);
        
        $items = [];
        foreach ($request->items as $index => $item) {
            $employee = Employee::find($item['employee_id'] ?? null);
            $uniform = MasterUniform::find($item['master_uniform_id']);
            
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            
            $items[] = [
                'no' => $index + 1,
                'nik' => $isManual ? ($item['manual_nik'] ?? '-') : ($employee->nik ?? '-'),
                'name' => $isManual ? ($item['manual_name'] ?? '-') : ($employee->name ?? '-'),
                'department' => $isManual ? ($item['manual_department'] ?? '-') : ($employee->department ?? '-'),
                'item_code' => $uniform->item_code ?? '-',
                'description' => $uniform->description ?? '-',
                'size' => $uniform->size ?? '-',
                'qty' => $item['qty'] ?? '-',
                'group' => $item['group'] ?? '-',
                'request_date' => $item['request_date'] ?? '-',
                'reason' => $item['reason'] ?? '-',
                'remarks' => $item['remarks'] ?? '-',
                'admin_feedback' => $item['admin_feedback'] ?? '-',
                'admin_feedback_datetime' => $item['admin_feedback_datetime'] ?? null,
                'admin_feedback_by' => $item['admin_feedback_by'] ?? null,
                'verification_status' => $item['verification_status'] ?? '-',
                'verification_datetime' => $item['verification_datetime'] ?? null,
                'verification_by' => $item['verification_by'] ?? '-',
                'verification_note' => $item['verification_note'] ?? '-',
                'costing_feedback' => $item['costing_feedback'] ?? '-',
                'costing_feedback_datetime' => $item['costing_feedback_datetime'] ?? null,
                'costing_feedback_by' => $item['costing_feedback_by'] ?? null,
                'digital_signature' => $item['digital_signature'] ?? null,
                'signature_datetime' => $item['signature_datetime'] ?? null,
                'signature_name' => $item['signature_name'] ?? '-',
                'signature_position' => $item['signature_position'] ?? '-',
                'is_manual' => $isManual,
            ];
        }
        
        // Hitung status
        $adminStatus = $this->getAdminFeedbackStatus($request);
        $costingStatus = $this->getCostingFeedbackStatus($request);
        $verificationStatus = $this->getVerificationStatus($request);
        $signatureStatus = $this->getSignatureStatus($request);
        
        $data = [
            'request' => $request,
            'items' => $items,
            'adminStatus' => $adminStatus,
            'costingStatus' => $costingStatus,
            'verificationStatus' => $verificationStatus,
            'signatureStatus' => $signatureStatus,
            'date' => now()->format('d F Y H:i'),
            'totalEmployee' => count($items),
        ];
        
        $pdf = Pdf::loadView('livewire.prod.uniform.uniform-request', $data);
        $pdf->setPaper('A4', 'landscape');
        
        // Sanitasi nama file - HAPUS karakter / dan \
        $filename = 'uniform-request-' . $request->id . '.pdf';
        // Atau gunakan ini jika ingin tetap pakai request_number tapi di-sanitasi:
        // $filename = 'uniform-request-' . str_replace(['/', '\\'], '-', $request->request_number) . '.pdf';
        
        return $pdf->stream($filename);
    }
    
    private function getAdminFeedbackStatus($request)
    {
        $items = $request->items ?? [];
        $totalItems = count($items);
        
        if ($totalItems == 0) {
            return ['status' => 'Open'];
        }
        
        $filledCount = 0;
        foreach ($items as $item) {
            if (!empty($item['admin_feedback'])) {
                $filledCount++;
            }
        }
        
        if ($filledCount == 0) {
            return ['status' => 'Open'];
        } elseif ($filledCount == $totalItems) {
            return ['status' => 'Checked'];
        } else {
            return ['status' => 'On Process'];
        }
    }
    
    private function getCostingFeedbackStatus($request)
    {
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return ['status' => 'Open'];
        }
        
        $totalItems = count($items);
        $checkedCount = 0;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            
            if ($verificationStatus === 'rejected') {
                $checkedCount++;
            } elseif (!empty($item['costing_feedback'])) {
                $checkedCount++;
            }
        }
        
        if ($checkedCount == $totalItems) {
            return ['status' => 'Checked'];
        } elseif ($checkedCount > 0) {
            return ['status' => 'On Process'];
        }
        
        return ['status' => 'Open'];
    }
    
    private function getVerificationStatus($request)
    {
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return ['status' => 'Waiting'];
        }
        
        $totalItems = count($items);
        $completedCount = 0;
        $approvedCount = 0;
        $manualCount = 0;
        $pendingCount = 0;
        $allManual = true;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            
            if (!$isManual) {
                $allManual = false;
            }
            
            if ($isManual) {
                $completedCount++;
                $manualCount++;
                continue;
            }
            
            if ($verificationStatus === 'approved') {
                $completedCount++;
                $approvedCount++;
            } elseif ($verificationStatus === 'rejected') {
                $completedCount++;
            } else {
                $pendingCount++;
            }
        }
        
        if ($allManual && $manualCount == $totalItems) {
            return ['status' => 'N/A'];
        }
        
        if ($completedCount == $totalItems) {
            if ($approvedCount == $totalItems) {
                return ['status' => 'Approved'];
            }
            return ['status' => 'Completed'];
        }
        
        if ($completedCount > 0) {
            return ['status' => 'On Process'];
        }
        
        return ['status' => 'Waiting'];
    }
    
    private function getSignatureStatus($request)
    {
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return ['status' => 'Waiting'];
        }
        
        $totalItems = count($items);
        $completedCount = 0;
        $signedCount = 0;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            $isSigned = !empty($item['digital_signature']);
            
            if ($verificationStatus === 'rejected') {
                $completedCount++;
            } elseif ($isSigned) {
                $completedCount++;
                $signedCount++;
            }
        }
        
        if ($completedCount == $totalItems) {
            if ($signedCount == $totalItems) {
                return ['status' => 'Signed'];
            }
            return ['status' => 'Completed'];
        }
        
        if ($completedCount > 0) {
            return ['status' => 'On Process'];
        }
        
        return ['status' => 'Waiting'];
    }
}