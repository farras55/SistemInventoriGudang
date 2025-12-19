<?php




session_start();


if (!isset($_SESSION['user'])) {
    header("Location: views/auth/login.php");
    exit;
}


header("Location: controllers/DashboardController.php?action=index");
exit;
