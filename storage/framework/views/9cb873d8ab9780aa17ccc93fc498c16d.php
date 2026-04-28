<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketing Support</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
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
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f0f8ff;
            width: 25%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">New Ticket</div>
        <div class="content">
            <p>
                Dear PIC ESD,
            </p>
            <p>Here is the latest ticket related to the problem/request:</p>
            <h3>Ticket Details</h3>
            <table>
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
                <tr>
                    <th>Ticket For</th>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($ticket->assigned_role):
                            case ('ADMINESD'): ?>
                                ESD (Electrostatic Discharge)
                                <?php break; ?>
                            <?php case ('ADMINHR'): ?>
                                Human Resource
                                <?php break; ?>
                            <?php case ('ADMINGA'): ?>
                                General Affair
                                <?php break; ?>
                            <?php case ('ADMINUTILITY'): ?>
                                Utility & Building
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($ticket->assigned_role); ?>

                        <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
            </table>
            <p>You can view the ticket directly by clicking the link below:</p>
            <p><strong>Link to Ticket:</strong> 
                <a href="http://portal.siix-ems.co.id/ticket/list/<?php echo e($ticket->id); ?>">View Ticket</a>
            </p>
            <p>Please check it for the approval process.</p>
            <p>Thank you,</p>
            <p>Best Regards,<br>Web Portal SIIX EMS Indonesia</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/ticket/created.blade.php ENDPATH**/ ?>