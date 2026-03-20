<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Submission Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #1d4ed8; color: #ffffff; padding: 20px; text-align: center;">
                            <h2 style="margin: 0; font-size: 24px;">Submission Status Update</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 20px; color: #333333; font-size: 16px; line-height: 1.5;">
                            <p>Hello,</p>
                            <p>The status of the following submission has been updated:</p>

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
                                    <td style="font-weight: bold;">Status</td>
                                    <td>
                                        :
                                        @if($submission->status === 'Received')
                                            <span style="display: inline-block; padding: 3px 8px; background-color: #22c55e; color: white; border-radius: 12px; font-weight: bold; font-size: 14px;">
                                                Received
                                            </span>
                                        @elseif($submission->status === 'Rejected')
                                            <span style="display: inline-block; padding: 3px 8px; background-color: #ef4444; color: white; border-radius: 12px; font-weight: bold; font-size: 14px;">
                                                Rejected
                                            </span>
                                        @else
                                            <span>{{ $submission->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($submission->status === 'Rejected')
                                <tr>
                                    <td style="font-weight: bold; color: #d32f2f;">Reason</td>
                                    <td>: {{ $submission->reason }}</td>
                                </tr>
                                @endif
                                <tr style="background-color: #f9f9f9;">
                                    <td style="font-weight: bold;">PIC</td>
                                    <td>: {{ $submission->pic }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Due Date</td>
                                    <td>: {{ $submission->due_date->format('d-m-Y') }}</td>
                                </tr>
                            </table>

                            <p style="margin-top: 20px;">Please take the necessary actions accordingly.</p>
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
