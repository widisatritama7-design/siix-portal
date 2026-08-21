<?php

namespace App\Helpers;

class PhoneHelper
{
    public static function formatToInternational($phone)
    {
        if (empty($phone)) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (empty($phone)) {
            return null;
        }
        
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }
}