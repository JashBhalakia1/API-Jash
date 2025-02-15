<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Dashboard</title>
    
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Dashboard Container */
        .dashboard-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        /* Header Styling */
        .dashboard-header {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            padding: 10px 0;
            border-bottom: 3px solid #007bff;
        }

        /* Report List */
        .report-list {
            list-style: none;
            padding: 0;
        }

        .report-list li {
            margin: 15px 0;
        }

        .report-list a {
            display: block;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background 0.3s ease;
            font-size: 18px;
            font-weight: bold;
        }

        .report-list a:hover {
            background-color: #0056b3;
        }

        /* Footer */
        .dashboard-footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }
    </style>

</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-header">📊 Report Dashboard</div>

    <ul class="report-list">
        <li><a href="sales_report.php">📈  Sales Report</a></li>
        <li><a href="user_report.php">👤 User Report</a></li>
        <li><a href="inventory_report.php">📦 Inventory Report</a></li>
        <li><a href="export_reports.php">📤 Export Reports (PDF/Excel)</a></li>
    </ul>

    <div class="dashboard-footer">
        &copy; <?php echo date("Y"); ?> Report System. All Rights Reserved.
    </div>
</div>

</body>
</html>
