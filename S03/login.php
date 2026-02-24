<?php
session_start();

if (!isset($_SESSION['fail'])) {
    $_SESSION['fail'] = 0;
}

$error = "";
$blocked = $_SESSION['fail'] >= 3;

if ($_SERVER["REQUEST_METHOD"] === "POST" && !$blocked) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $file = "storage/users.json";
    $users = file_exists($file)
        ? json_decode(file_get_contents($file), true)
        : [];

    foreach ($users as $user) {

        if (
            $user['username'] === $username &&
            password_verify($password, $user['password'])
        ) {

            session_regenerate_id(true);

            $_SESSION['user'] = $username;
            $_SESSION['fail'] = 0;

            header("Location: dashboard.php");
            exit();
        }
    }

    $_SESSION['fail']++;
    $error = "Incorrect account or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- ✅ CSS riêng -->
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

<div class="login-container">

    <h2>Welcome Back</h2>

    <?php if ($blocked): ?>
        <div class="error">
            You have entered the wrong password more than 3 times.
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button <?= $blocked ? 'disabled' : '' ?>>
            Login
        </button>

    </form>

    <a href="register.php">Create account</a>

</div>

</body>
</html>