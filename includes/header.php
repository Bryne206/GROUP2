<?php>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="assets/style.css">
  <title>Event Registration System</title>
</head>
<body>
<header>
  <h1>Campus Event Registration</h1>
  <nav>
    <a href="index.php">Home</a>
    <?php if(isset($_SESSION["user_id"])): ?>
      <a href="dashboard.php">Dashboard</a>
      <a href="events.php">Events</a>
      <a href="my_registrations.php">My Registrations</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="register.php">Register</a>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </nav>
</header>
<main>