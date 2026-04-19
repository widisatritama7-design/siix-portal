<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Ticket Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #b3d9ff;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .ticket-table th, .ticket-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .ticket-table th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Ticket Created</div>
        <div class="content">
            <p>Dear User,</p>
            <p>Your ticket has been successfully created. Here are the details:</p>
            
            <h3>Ticket Details</h3>
            <table class="ticket-table">
                <tr>
                    <th>Ticket Number</th>
                    <td><?php echo e($ticket->ticket_number); ?></td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td><?php echo e($ticket->title); ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?php echo e($ticket->description); ?></td>
                </tr>
            </table>
            
            <p>You can view the ticket directly by clicking the link below:</p>
            <p><strong>Link to Ticket:</strong> <a href="http://portal.siix-ems.co.id/mainMenu/tickets/<?php echo e($ticket->id); ?>">View Ticket</a></p>
            
            <p>Thank you for reaching out!</p>
            <p>Best Regards,<br>Web Portal SIIX EMS Indonesia</p>
        </div>
    </div>
</body>
</html><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\emails\Ticket\created_for_user.blade.php ENDPATH**/ ?>