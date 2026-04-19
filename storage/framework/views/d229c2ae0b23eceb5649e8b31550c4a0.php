<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Update on Your Ticket</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      width: 80%;
      max-width: 700px;
      margin: 20px auto;
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .header {
      background-color: #b3d9ff;
      padding: 20px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
      color: #000;
    }
    .content {
      padding: 25px 20px;
      color: #333;
      line-height: 1.5;
    }
    table.feedback-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table.feedback-table th, table.feedback-table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
      vertical-align: top;
    }
    table.feedback-table th {
      background-color: #f0f8ff;
      width: 30%;
      font-weight: 600;
    }
    a {
      color: #007bff;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #888;
      padding: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">Update on Your Ticket</div>
    <div class="content">
      <p>Dear <?php echo e($feedback->ticket->creator->name ?? 'User'); ?>,</p>
      <p>There is a new update on your ticket:</p>
      <h3>Ticket Details</h3>
      <table class="feedback-table">
         <tr>
          <th>Ticket Number</th>
          <td><?php echo e($feedback->ticket->ticket_number ?? 'N/A'); ?></td>
         </tr>
         <tr>
          <th>Status</th>
          <td><?php echo e($feedback->status ?? 'N/A'); ?></td>
         </tr>
         <tr>
          <th>Comments</th>
          <td><?php echo e($feedback->comments ?? 'N/A'); ?></td>
         </tr>
         <tr>
          <th>Updated By</th>
          <td><?php echo e($feedback->user->name ?? 'System'); ?></td>
         </tr>
       </table>
      <p>You can view the ticket directly by clicking the link below:</p>
      <p><strong>Link to Ticket:</strong> <a href="<?php echo e(url('/ticket/list/' . $feedback->ticket_id)); ?>">View Ticket</a></p>
      <p>Thank You</p>
      <p>Best Regards,<br />Web Portal SIIX EMS Indonesia</p>
    </div>
  </div>
</body>
</html><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\emails\Ticket\feedback_created_for_user.blade.php ENDPATH**/ ?>