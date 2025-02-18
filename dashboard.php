

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional Icons (for better visual) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            width: 250px;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px;
            font-size: 18px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575d63;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .card-body {
            font-size: 16px;
        }

        .navbar-custom {
            background-color: #007bff;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-nav .nav-link {
            color: white;
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #d1d1d1;
        }

        .welcome-message {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 24px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Welcome, </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center text-white">Menu</h3>
        <a href="dashboard.php"><i class="bi bi-house-door-fill"></i> Dashboard</a>
        <a href="manage_users.php"><i class="bi bi-person-lines-fill"></i> Manage Users</a>
        <a href="order_reservation.php"><i class="bi bi-card-checklist"></i> Order Reservation</a>
        <a href="manage_inventory.php"><i class="bi bi-box"></i> Inventory Management</a>
        <a href="sales.php"><i class="bi bi-bar-chart-line"></i> Sales</a>
        <a href="report_dashboard.php"><i class="bi bi-file-earmark-earbuds"></i> Reports</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Welcome message -->
        <div class="welcome-message">
            <h1>Welcome to your Dashboard, </h1>
            <p>Manage users, orders, inventory, view reports, and much more from here.</p>
        </div>

        <!-- Section for User Management 
        <div class="card">
            <div class="card-header">User Management</div>
            <div class="card-body">
                <p>Manage all users, reset credentials using two-factor authentication, and update user details.</p>
                <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
            </div>
        </div>

         Section for Order Reservation
        <div class="card">
            <div class="card-header">Order Reservation</div>
            <div class="card-body">
                <p>View and manage all orders placed by customers.</p>
                <a href="order_reservation.php" class="btn btn-primary">View Orders</a>
            </div>
        </div>

        Section for Inventory Management
        <div class="card">
            <div class="card-header">Inventory Management</div>
            <div class="card-body">
                <p>Track and manage your product inventory.</p>
                <a href="manage_inventory.php" class="btn btn-primary">Manage Inventory</a>
            </div>
        </div>

        Section for Analytics
        

        Section for Reports 
        <div class="card">
            <div class="card-header">Reports</div>
            <div class="card-body">
                <p>Generate and export reports in PDF or Excel format.</p>
                <a href="report_dashboard.php" class="btn btn-primary">View Reports</a>
            </div>
        </div>
    </div> -->

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
