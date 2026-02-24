<?php
require_once "config/session.php";
requireLogin();

// ===== LOAD USERS =====
$file = "storage/users.json";
$users = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

$currentUser = null;
$userIndex = null;

foreach ($users as $index => $u) {
    if ($u['username'] === $_SESSION['user']) {
        $currentUser = $u;
        $userIndex = $index;
        break;
    }
}

if ($currentUser === null) {
    die("User not found");
}

$success = "";
$error = "";

// ===== HANDLE UPDATE =====
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Không escape khi lưu (escape khi output)
    $bio = trim($_POST['bio'] ?? '');

    // ===== AVATAR UPLOAD =====
    if (!empty($_FILES['avatar']['name'])) {

        $allowedExt  = ['jpg','jpeg','png'];
        $allowedMime = ['image/jpeg','image/png'];

        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

        // Check extension
        if (!in_array($ext, $allowedExt)) {
            $error = "Only JPG, JPEG, PNG files are allowed.";
        }

        // Check MIME type thật sự
        if ($error === "") {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['avatar']['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mime, $allowedMime)) {
                $error = "Invalid file type.";
            }
        }

        // Check file size (max 2MB)
        if ($error === "" && $_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            $error = "File too large (max 2MB).";
        }

        // Nếu không có lỗi → upload
        if ($error === "") {

            if (!is_dir("uploads/avatars")) {
                mkdir("uploads/avatars", 0755, true);
            }

            $filename = uniqid("avatar_", true) . "." . $ext;
            $target = "uploads/avatars/" . $filename;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
                $users[$userIndex]['avatar'] = $filename;
            } else {
                $error = "Upload failed.";
            }
        }
    }

    // Nếu không có lỗi → lưu bio
    if ($error === "") {

        $users[$userIndex]['bio'] = $bio;

        file_put_contents(
            $file,
            json_encode($users, JSON_PRETTY_PRINT)
        );

        $currentUser = $users[$userIndex];
        $success = "Profile updated successfully!";
    }
}

$username = htmlspecialchars($_SESSION['user']);
$avatar = !empty($currentUser['avatar'])
    ? "uploads/avatars/" . $currentUser['avatar']
    : "https://i.pravatar.cc/150?u=" . urlencode($username);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/css/profile.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>MyApp</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a class="active" href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN -->
<div class="main">

    <div class="profile-card">

        <h2>User Profile</h2>

        <?php if($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- AVATAR -->
        <img class="avatar" src="<?= htmlspecialchars($avatar) ?>" alt="Avatar">

        <h3><?= $username ?></h3>

        <form method="POST" enctype="multipart/form-data">

            <label>Bio</label>
            <textarea name="bio" rows="5"><?= htmlspecialchars($currentUser['bio'] ?? '') ?></textarea>

            <label>Change Avatar</label>
            <input type="file" name="avatar" accept=".jpg,.jpeg,.png">

            <button type="submit">Save Changes</button>

        </form>

    </div>

</div>

</body>
</html>