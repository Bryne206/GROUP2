<?php require_once "includes/config.php"; ?>
<?php include "includes/header.php"; ?>

<section class="card">
  <h2>System Overview</h2>
  <p>This system allows users to create an account, log in, and register for campus events.</p>

  <?php if(!isset($_SESSION["user_id"])): ?>
    <div class="actions">
      <a class="btn" href="register.php">Create Account</a>
      <a class="btn" href="login.php">Login</a>
    </div>
  <?php else: ?>
    <div class="actions">
      <a class="btn" href="events.php">View Events</a>
      <a class="btn" href="dashboard.php">Go to Dashboard</a>
    </div>
  <?php endif; ?>
</section>

<?php include "includes/footer.php"; ?>