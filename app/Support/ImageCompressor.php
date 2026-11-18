<?php

namespace App\Support;

class ImageCompressor
{
    /**
     * Kompres & resize gambar, kembalikan data URI base64.
     * Return null jika file tidak ada / gagal dibaca.
     */
    public static function toDataUri(string $absolutePath, int $maxWidth = 160, int $quality = 55): ?string
    {
        if (!is_file($absolutePath)) {
            return null;
        }

        $info = @getimagesize($absolutePath);
        if (!$info) {
            return null;
        }

        [$width, $height] = $info;
        $mime = $info['mime'] ?? '';

        // Buat resource dari file asli
        $src = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($absolutePath),
            'image/png'  => @imagecreatefrompng($absolutePath),
            'image/gif'  => @imagecreatefromgif($absolutePath),
            'image/webp' => @imagecreatefromwebp($absolutePath),
            default      => null,
        };

        if (!$src) {
            // Fallback: kirim file asli tanpa kompres
            return self::rawDataUri($absolutePath, $mime);
        }

        // Hitung dimensi baru (jaga aspect ratio)
        $ratio = $width > $maxWidth ? $maxWidth / $width : 1;
        $newW  = max(1, (int) round($width * $ratio));
        $newH  = max(1, (int) round($height * $ratio));

        $dst = imagecreatetruecolor($newW, $newH);

        // Pertahankan transparansi untuk PNG/GIF/WebP
        if (in_array($mime, ['image/png', 'image/gif', 'image/webp'], true)) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $newW, $newH, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $width, $height);

        // Output ke buffer sebagai JPEG (paling kecil untuk PDF)
        ob_start();
        imagejpeg($dst, null, $quality);
        $binary = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        return 'data:image/jpeg;base64,' . base64_encode($binary);
    }

    /**
     * Fallback tanpa GD: baca file mentah.
     */
    private static function rawDataUri(string $path, string $mime): ?string
    {
        $data = @file_get_contents($path);
        if ($data === false) {
            return null;
        }
        $mime = $mime ?: 'image/' . pathinfo($path, PATHINFO_EXTENSION);
        return 'data:' . $mime . ';base64,' . base64_encode($data);
    }
}