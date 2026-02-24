<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = trim($_POST['confirm']);

    // ===== VALIDATION =====
    if ($username === "" || $password === "") {
        $error = "Không được để trống";
    }
    elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $error = "Username chỉ gồm chữ, số, _ (3–20 ký tự)";
    }
    elseif ($password !== $confirm) {
        $error = "Password không khớp";
    }
    elseif (strlen($password) < 6) {
        $error = "Password phải >= 6 ký tự";
    }
    else {

        $file = "storage/users.json";

        // tạo file nếu chưa tồn tại
        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
        }

        $users = json_decode(file_get_contents($file), true) ?? [];

        // kiểm tra username trùng
        foreach ($users as $user) {
            if ($user["username"] === $username) {
                $error = "Username đã tồn tại";
                break;
            }
        }

        // ===== SAVE USER =====
        if ($error === "") {

            $users[] = [
                "username" => $username,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "bio" => "",
                "avatar" => ""
            ];

            file_put_contents(
                $file,
                json_encode($users, JSON_PRETTY_PRINT)
            );

            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- CSS riêng -->
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>

<div class="register-container">

    <h2>Create Account</h2>

    <?php if ($error): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
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

        <input type="password"
               name="confirm"
               placeholder="Confirm Password"
               required>

        <button type="submit">Register</button>

    </form>

    <a href="login.php">Already have an account?</a>

</div>

</body>
</html>