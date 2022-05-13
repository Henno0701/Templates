<?php
session_start();
// Als de User niet is ingelogd redirect naar...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../Index.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <!-- Imports -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <!-- StyleSheet -->
    <link type="text/css" rel="stylesheet" href="../css/home-style.css">
    <!-- JavaScript -->
    <script src="../js/jquery-3.6.0.min.js"></script>
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Website Title</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
    <h2>Home Page</h2>
    <p>Welcome back, <?=$_SESSION['name']?>!</p>
</div>
</body>
</html>
