<!-- resources/views/emails/pending-master-sample-single.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pending Master Sample</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f7; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <tr>
            <td>
                <h2 style="color: #333333; margin-bottom: 20px;">Halo {{ $user->name }},</h2>

                <p style="font-size: 16px; color: #555555; line-height: 1.5;">
                    Anda memiliki total 
                    <strong style="color: #000000;">{{ $total }}</strong> 
                    Master Sample yang perlu segera di 
                    <strong style="color: #000000;">{{ $type }}</strong>.
                </p>

                <p style="font-size: 16px; color: #555555; line-height: 1.5;">
                    Silakan lakukan tindakan sesegera mungkin dengan klik tombol di bawah:
                </p>

                <!-- Tombol link -->
                <p style="text-align: center; margin: 30px 0;">
                    <a href="https://portal.siix-ems.co.id/prod/ms/sample-checks" 
                       style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                        View Task Master Sample
                    </a>
                </p>

                <p style="font-size: 16px; color: #555555; line-height: 1.5;">
                    Terima kasih,<br>
                    <strong>SIIX EMS Notification</strong>
                </p>

                <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">

                <p style="font-size: 12px; color: #999999; text-align: center;">
                    Email ini dikirim otomatis, mohon tidak membalas.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
