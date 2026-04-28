<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Baru</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f7; padding: 20px;">

    <table style="max-width: 650px; margin: auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <!-- Header -->
        <tr>
            <td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 25px;">
                <h1 style="margin:0; font-size: 26px;">💬 Feedback Baru Diterima</h1>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 25px;">
                <p>Halo tim,</p>
                <p>Ada feedback baru yang masuk. Detailnya sebagai berikut:</p>

                <!-- Detail Feedback -->
                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                    <tr>
                        <td style="font-weight: bold; padding: 10px; background-color: #eef2ff; width: 150px;">Nama</td>
                        <td style="padding: 10px;">{{ $feedbackName }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 10px; background-color: #eef2ff;">Email</td>
                        <td style="padding: 10px;">{{ $feedbackEmail }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 10px; background-color: #eef2ff;">Kategori</td>
                        <td style="padding: 10px;">
                            @php
                                $colors = [
                                    'bug' => '#ef4444',         // merah
                                    'improvement' => '#f59e0b', // oranye
                                    'general' => '#06b6d4',     // biru
                                ];
                                $badgeColor = $colors[$feedbackCategory] ?? '#999';
                                $categoryLabel = ucfirst($feedbackCategory);
                            @endphp
                            <span style="background-color: {{ $badgeColor }}; color: #fff; padding: 4px 10px; border-radius: 12px; font-size: 14px;">
                                {{ $categoryLabel }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 10px; background-color: #eef2ff;">Pesan</td>
                        <td style="padding: 10px; white-space: pre-wrap;">{{ $feedbackMessage }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding: 10px; background-color: #eef2ff;">URL</td>
                        <td style="padding: 10px;">
                            @if(!empty($feedbackURL))
                                <a href="{{ $feedbackURL }}" target="_blank" style="color: #4f46e5; text-decoration: underline;">
                                    {{ $feedbackURL }}
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                </table>

                <p style="margin-top: 20px; text-align: center;">— Sistem Feedback SIIX Portal —</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f4f4f7; text-align: center; padding: 12px; font-size: 12px; color: #999;">
                SIIX Portal &copy; {{ date('Y') }}
            </td>
        </tr>
    </table>

</body>
</html>
