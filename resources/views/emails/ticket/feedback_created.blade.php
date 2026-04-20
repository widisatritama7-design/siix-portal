<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>New Feedback Ticket</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      color: #333;
    }
    .container {
      width: 80%;
      max-width: 700px;
      margin: 20px auto;
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
      background-color: #b3d9ff;
      padding: 25px 20px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
      color: #000;
    }
    .content {
      padding: 20px 25px;
      line-height: 1.5;
    }
    table.feedback-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table.feedback-table th, table.feedback-table td {
      border: 1px solid #ddd;
      padding: 14px 12px;
      text-align: left;
      vertical-align: top;
    }
    table.feedback-table th {
      background-color: #e8f0fe;
      font-weight: 600;
      width: 30%;
    }
    a {
      color: #1a73e8;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
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
    <div class="header">New Feedback Ticket</div>
    <div class="content">
      <p>Dear Admin,</p>
      <p>Here is the Feedback data from the Ticket below:</p>
      <h3>Feedback Details</h3>
      <table class="feedback-table">
         <tr>
          <th>Ticket Number</th>
          <td>{{ $feedback->ticket->ticket_number ?? 'N/A' }}</td>
         </tr>
         <tr>
          <th>Comments</th>
          <td>{{ $feedback->comments ?? 'N/A' }}</td>
         </tr>
         <tr>
          <th>Status</th>
          <td>{{ $feedback->status ?? 'N/A' }}</td>
         </tr>
         <tr>
          <th>Technician</th>
          <td>{{ $feedback->user->name ?? 'System' }}</td>
         </tr>
         <tr>
          <th>Created At</th>
          <td>{{ $feedback->created_at ? $feedback->created_at->format('d M Y H:i') : 'N/A' }}</td>
         </tr>
       </table>
      <p>You can view the ticket directly by clicking the link below:</p>
      <p><strong>Link to Ticket:</strong> <a href="{{ url('/ticket/list/' . $feedback->ticket_id) }}">View Ticket</a></p>
      <p>Thank You</p>
      <p>Best Regards,<br />Web Portal SIIX EMS Indonesia</p>
    </div>
  </div>
</body>
</html>