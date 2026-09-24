<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f7; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f7; padding: 30px 0;">
        <tr>
            <td align="center">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                       style="background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.06);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:{{ $methodColor }}; padding: 28px 30px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:20px; font-weight:bold;">
                                {{ $methodLabel }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">

                            <p style="margin:0 0 14px; font-size:15px; color:#1f2937;">
                                Halo <strong>{{ $recipient->name }}</strong>,
                            </p>

                            <p style="margin:0 0 20px; font-size:14px; color:#4b5563; line-height:1.6;">
                                {!! nl2br(e($messageBody)) !!}
                            </p>

                            <!-- Action Box -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                   style="background-color:#f9fafb; border-left:4px solid {{ $methodColor }}; border-radius:6px; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 16px 18px;">
                                        <p style="margin:0; font-size:13px; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">
                                            Tindakan yang diperlukan
                                        </p>
                                        <p style="margin:6px 0 0; font-size:16px; color:#111827; font-weight:bold;">
                                            {{ $actionText }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Recipient Info -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin-top: 20px; border:1px solid #e5e7eb; border-radius:6px; overflow:hidden;">
                                <tr style="background-color:#f9fafb;">
                                    <td colspan="2" style="padding: 10px 16px; font-size:13px; color:#6b7280; font-weight:bold; border-bottom:1px solid #e5e7eb;">
                                        Detail Karyawan
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; font-size:13px; color:#6b7280; width:140px;">NIK</td>
                                    <td style="padding: 10px 16px; font-size:13px; color:#111827; font-weight:600;">
                                        {{ $recipient->nik ?? '-' }}
                                    </td>
                                </tr>
                                <tr style="background-color:#f9fafb;">
                                    <td style="padding: 10px 16px; font-size:13px; color:#6b7280;">Name</td>
                                    <td style="padding: 10px 16px; font-size:13px; color:#111827; font-weight:600;">
                                        {{ $recipient->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 16px; font-size:13px; color:#6b7280;">Department</td>
                                    <td style="padding: 10px 16px; font-size:13px; color:#111827; font-weight:600;">
                                        {{ $recipient->department ?? '-' }}
                                    </td>
                                </tr>
                                <tr style="background-color:#f9fafb;">
                                    <td style="padding: 10px 16px; font-size:13px; color:#6b7280;">Date Measure</td>
                                    <td style="padding: 10px 16px; font-size:13px; color:#111827; font-weight:600;">
                                        {{ $recipient->date_measure ? \Carbon\Carbon::parse($recipient->date_measure)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:24px 0 0; font-size:13px; color:#6b7280; line-height:1.6;">
                                Untuk pertanyaan lebih lanjut, silakan hubungi Tim ESD (087883994150).
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f9fafb; padding: 20px 30px; text-align:center; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af;">
                                Email ini dikirim otomatis oleh sistem {{ config('app.name') }}.
                            </p>
                            <p style="margin:6px 0 0; font-size:12px; color:#9ca3af;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>