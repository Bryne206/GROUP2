<?php
require_once "includes/config.php";
require_once "includes/auth.php";
include "includes/header.php";


$stmt = $conn->prepare("SELECT full_name, email, phone, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<section class="card">
    <h2>Welcome, <?php echo htmlspecialchars($user["full_name"]); ?> 👋</h2>

    <?php if ($user["profile_image"]): ?>
        <img src="<?php echo $user["profile_image"]; ?>" 
             alt="Profile Image" 
             style="width:120px; height:120px; border-radius:50%; object-fit:cover;">
    <?php endif; ?>

    <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user["phone"]); ?></p>

    <hr>

    <div class="actions">
        <a class="btn" href="events.php">View Events</a>
        <a class="btn" href="my_registrations.php">My Registrations</a>
        <a class="btn" href="logout.php" style="background:#ef4444;">Logout</a>
    </div>
</section>

<?php include "includes/footer.php"; ?>