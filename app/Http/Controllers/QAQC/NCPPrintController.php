<?php

namespace App\Http\Controllers\QAQC;

use App\Models\QAQC\NCP;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class NCPPrintController extends Controller
{
    public function print($id)
    {
        $ncp = NCP::with(['employee', 'creator', 'approver'])->findOrFail($id);
        
        // Cek apakah NCP lengkap (harus ada data minimal)
        if (!$this->isNCPComplete($ncp)) {
            abort(400, 'NCP data is incomplete. Please complete all required fields before printing.');
        }
        
        // Generate serial number jika belum ada
        if (!$ncp->serial_number_barcode) {
            $ncp->serial_number_barcode = NCP::generateSerialNumberBarcode();
        }
        
        // Increment print count - pastikan tidak double
        // Jika print_count null, set ke 1, selain itu increment
        if ($ncp->print_count === null || $ncp->print_count == 0) {
            $ncp->print_count = 1;
        } else {
            $ncp->print_count = $ncp->print_count + 1;
        }
        
        $ncp->last_printed_at = now();
        $ncp->save();

        $barcode = $this->generateBarcode($ncp->serial_number_barcode);
        
        $data = [
            'ncp' => $ncp,
            'barcode' => $barcode,
        ];

        $pdf = Pdf::loadView('livewire.qaqc.ncp-print', $data);
        
        // Ubah ke A5 Landscape
        $pdf->setPaper('a5', 'landscape');
        
        // FIX: Replace slash dengan underscore atau karakter lain yang aman
        $filename = 'NCP-' . str_replace('/', '_', $ncp->ncp_number) . '.pdf';
        
        return $pdf->stream($filename);
    }

    /**
     * Check if NCP has minimum required data
     */
    private function isNCPComplete($ncp)
    {
        // Minimal harus ada employee_id dan ncp_number
        if (empty($ncp->employee_id) || empty($ncp->ncp_number)) {
            return false;
        }
        
        // Cek apakah ada defect details
        $hasDefect = !empty($ncp->defect_details) && count($ncp->defect_details) > 0;
        
        // Cek apakah ada disposition
        $hasDisposition = !empty($ncp->disposition);
        
        // Harus ada minimal 1 defect atau 1 disposition
        if (!$hasDefect && !$hasDisposition) {
            return false;
        }
        
        return true;
    }

    private function generateBarcode($serialNumber)
    {
        try {
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            $barcode = base64_encode($generator->getBarcode($serialNumber, $generator::TYPE_CODE_128, 2, 50));
            return $barcode;
        } catch (\Exception $e) {
            \Log::error('Barcode generation error: ' . $e->getMessage());
            return null;
        }
    }
}