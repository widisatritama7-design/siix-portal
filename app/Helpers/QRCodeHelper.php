<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QRCodeHelper
{
    public static function generateAndSave($accessCode, $data)
    {
        try {
            // Jika $data sudah string, gunakan langsung
            // Jika $data array, encode ke JSON
            if (is_array($data)) {
                $qrContent = json_encode($data);
            } else {
                $qrContent = (string) $data;  // Pastikan string
            }
            
            Log::info('Generating QR Code...', [
                'access_code' => $accessCode,
                'qr_content' => $qrContent
            ]);
            
            // URL encode content untuk QR Code API
            $encodedContent = urlencode($qrContent);
            
            $response = Http::timeout(10)->get('https://api.qrserver.com/v1/create-qr-code/', [
                'size' => '400x400',
                'data' => $encodedContent,  // Gunakan encoded content
                'margin' => 15,
                'format' => 'png'
            ]);
            
            if (!$response->successful()) {
                Log::error('QR Code API failed', [
                    'status' => $response->status()
                ]);
                return null;
            }
            
            $imageContent = $response->body();
            
            $filename = 'qr_codes/' . $accessCode . '.png';
            Storage::disk('public')->put($filename, $imageContent);
            
            if (Storage::disk('public')->exists($filename)) {
                $fullPath = Storage::disk('public')->path($filename);
                Log::info('QR Code saved', [
                    'path' => $fullPath,
                    'size' => Storage::disk('public')->size($filename)
                ]);
                return $fullPath;
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('QR Code generation failed: ' . $e->getMessage());
            return null;
        }
    }

    public static function getBase64($accessCode, $data)
    {
        try {
            if (is_array($data)) {
                $qrContent = json_encode($data);
            } else {
                $qrContent = (string) $data;
            }
            
            $encodedContent = urlencode($qrContent);
            
            $response = Http::timeout(10)->get('https://api.qrserver.com/v1/create-qr-code/', [
                'size' => '250x250',
                'data' => $encodedContent,
                'margin' => 10,
                'format' => 'png'
            ]);
            
            if (!$response->successful()) {
                return null;
            }
            
            $imageContent = $response->body();
            return 'data:image/png;base64,' . base64_encode($imageContent);
        } catch (\Exception $e) {
            Log::error('QR Code base64 failed: ' . $e->getMessage());
            return null;
        }
    }

    public static function getUrl($accessCode)
    {
        return asset('storage/qr_codes/' . $accessCode . '.png');
    }

    public static function getFullPath($accessCode)
    {
        return Storage::disk('public')->path('qr_codes/' . $accessCode . '.png');
    }

    public static function exists($accessCode)
    {
        return Storage::disk('public')->exists('qr_codes/' . $accessCode . '.png');
    }

    public static function delete($accessCode)
    {
        try {
            $filename = 'qr_codes/' . $accessCode . '.png';
            if (Storage::disk('public')->exists($filename)) {
                Storage::disk('public')->delete($filename);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('QR Code delete failed: ' . $e->getMessage());
            return false;
        }
    }
}