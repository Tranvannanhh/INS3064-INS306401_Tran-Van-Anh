<?php
require_once 'config/session.php';
requireLogin();

$username = htmlspecialchars($_SESSION['user']);

// load users (demo stats)
$users = json_decode(file_get_contents("storage/users.json"), true) ?? [];
$totalUsers = count($users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <h2>MyApp</h2>

    <ul>
        <li><a class="active" href="dashboard.php">Dashboard</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>


<!-- ===== MAIN CONTENT ===== -->
<div class="main">

    <!-- HEADER -->
    <div class="header">
        <input type="text" placeholder="Search...">

        <div class="user-box">
            <span><?= $username ?></span>
            <img src="https://i.pravatar.cc/40" alt="avatar">
        </div>
    </div>

    <!-- STATS -->
    <div class="stats">

        <div class="card">
            <h4>Total Users</h4>
            <p><?= $totalUsers ?></p>
        </div>

        <div class="card">
            <h4>Active Sessions</h4>
            <p>1</p>
        </div>

        <div class="card">
            <h4>Profile Updated</h4>
            <p><?= rand(5,20) ?></p>
        </div>

        <div class="card">
            <h4>System Status</h4>
            <p style="color:#16a34a;">Online</p>
        </div>

    </div>


    <!-- TABLE -->
    <div class="table-box">
        <h3>Registered Users</h3>

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td>
                        <span class="status active">Active</span>
                    </td>
                    <td>
                        <button class="btn btn-primary">View</button>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>

</body>
</html>