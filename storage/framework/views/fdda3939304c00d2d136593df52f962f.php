<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kaizen Updates Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0; padding: 0;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .btn {
            background: #4CAF50;
            color: white !important;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .status-message {
            font-weight: bold;
            color: #4CAF50;
        }
        .no-updates {
            color: #f44336;
            font-weight: bold;
        }
        .charts-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        .chart-wrapper {
            flex: 1 1 48%;
            min-width: 300px;
        }
        img.chart {
            width: 100%;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kaizen Updates This Week</h1>
        </div>
        <div class="content">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kaizenCount > 0): ?>
                <p>There have been <span class="status-message"><?php echo e($kaizenCount); ?></span> new Kaizen entries this week.</p>
                <p>For more details, visit the <a href="<?php echo e($url); ?>" class="btn">Kaizen page</a>.</p>

                <div class="charts-row">
                    <div class="chart-wrapper">
                        <p><strong>Process & Status Chart (Bar):</strong></p>
                        <img src="<?php echo e($chartImageUrl); ?>" alt="Kaizen Bar Chart" class="chart" />
                    </div>
                    <div class="chart-wrapper">
                        <p><strong>Kaizen Rank by Process (Donut):</strong></p>
                        <img src="<?php echo e($rankChartImageUrl); ?>" alt="Kaizen Donut Chart" class="chart" />
                    </div>
                </div>
            <?php else: ?>
                <p class="no-updates">No new Kaizen entries this week.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="footer">
            <p>If you have any questions, feel free to <a href="mailto:sek.esd@siix-global.com">contact us</a>.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/prod/kaizen_updates.blade.php ENDPATH**/ ?>