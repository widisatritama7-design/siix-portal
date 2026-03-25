<?php
// database/seeders/SiteNotificationSeeder.php

namespace Database\Seeders;

use App\Models\HR\SiteNotification;
use Illuminate\Database\Seeder;

class SiteNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (optional)
        SiteNotification::truncate();

        // Sample notifications
        $notifications = [
            [
                'icon' => 'star',
                'message' => 'Website Baru, Selamat Menggunakan! 🎉',
                'button_text' => 'Lihat Fitur Baru',
                'button_url' => '/features',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'bell',
                'message' => 'Maintenance akan dilakukan pada tanggal 1 April 2026 pukul 02:00 WIB',
                'button_text' => 'Detail',
                'button_url' => '/maintenance',
                'is_active' => false,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'information-circle',
                'message' => 'Update keamanan terbaru telah diterapkan. Silakan perbarui password Anda.',
                'button_text' => 'Update Password',
                'button_url' => '/profile/edit',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'sparkles',
                'message' => 'Fitur baru: Export data sekarang tersedia! Coba sekarang.',
                'button_text' => 'Coba Sekarang',
                'button_url' => '/export',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'chat-bubble-left-right',
                'message' => 'Ada 5 permintaan baru menunggu persetujuan Anda',
                'button_text' => 'Lihat Permintaan',
                'button_url' => '/inbox',
                'is_active' => true,
                'display_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'calendar',
                'message' => 'Meeting bulanan akan dilaksanakan besok pukul 09:00 WIB',
                'button_text' => 'Lihat Jadwal',
                'button_url' => '/calendar',
                'is_active' => false,
                'display_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'rocket',
                'message' => 'Selamat datang di versi 2.0! Nikmati pengalaman baru yang lebih baik.',
                'button_text' => 'Lihat Changelog',
                'button_url' => '/changelog',
                'is_active' => true,
                'display_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'check-circle',
                'message' => 'Sistem backup berhasil dilakukan. Data Anda aman.',
                'button_text' => null,
                'button_url' => null,
                'is_active' => true,
                'display_order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($notifications as $notification) {
            SiteNotification::create($notification);
        }
    }
}