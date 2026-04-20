<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document Distributed</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #9333ea; color: #ffffff; padding: 20px; text-align: center;">
                            <h2 style="margin: 0; font-size: 24px;">Document Distributed</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 20px; color: #333333; font-size: 16px; line-height: 1.5;">
                            <p>Hello,</p>
                            <p>The following document has been <strong style="color: #9333ea;">Distributed</strong>:</p>

                            <table width="100%" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="font-weight: bold; width: 150px;">Description</td>
                                    <td>: {{ $submission->description }}</td>
                                </tr>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="font-weight: bold;">Category</td>
                                    <td>: {{ $submission->category_document }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Department</td>
                                    <td>: {{ $submission->dept }}</td>
                                </tr>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="font-weight: bold;">Distributed By</td>
                                    <td>: {{ $submission->distributed_by }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Distributed </td>
                                    <td>: {{ $submission->distributed_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="font-weight: bold;">PIC</td>
                                    <td>: {{ $submission->pic }}</td>
                                </tr>
                            </table>

                            <p style="margin-top: 20px;">The document is now available for your reference.</p>
                            <p>Regards,<br><strong>DCC Team</strong></p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #e5e7eb; color: #555555; text-align: center; padding: 15px; font-size: 12px;">
                            &copy; {{ date('Y') }} SIIX Global. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>