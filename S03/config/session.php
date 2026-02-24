<?php
session_start();

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
}
