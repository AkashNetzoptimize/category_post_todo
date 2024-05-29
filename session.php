<?php
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userRole = isset($_SESSION['userSelect']) && $_SESSION['userSelect'] === 'admin' ? 'admin' : 'user';
if ($userRole === 'admin') {
    include_once 'navbar.php';
} else {
    include_once 'usernav.php';
}

// echo "userSelect: " . $_SESSION['userSelect'];
// echo "userRole: " . $userRole;