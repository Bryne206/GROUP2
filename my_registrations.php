<?php
require_once "includes/config.php";
require_once "includes/auth.php";
include "includes/header.php";

$user_id = (int)$_SESSION["user_id"];
$success = "";
$errors = [];


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cancel_event_id"])) {
    $event_id = (int)$_POST["cancel_event_id"];

    $stmt = $conn->prepare("DELETE FROM registrations WHERE user_id = ? AND event_id = ?");
    $stmt->bind_param("ii", $user_id, $event_id);

    if ($stmt->execute()) {
       
        if ($stmt->affected_rows > 0) {
            $success = "Registration cancelled successfully.";
        } else {
            $errors[] = "Nothing to cancel (you may not be registered).";
        }
    } else {
        $errors[] = "Could not cancel registration. Try again.";
    }
    $stmt->close();
}


$stmt = $conn->prepare("
    SELECT e.id, e.title, e.event_date, e.venue, e.category, r.registered_at
    FROM registrations r
    INNER JOIN events e ON e.id = r.event_id
    WHERE r.user_id = ?
    ORDER BY e.event_date ASC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="card">
    <h2>My Registrations</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo $e; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($result->num_rows === 0): ?>
        <p>You have not registered for any events yet.</p>
        <a class="btn" href="events.php">Go to Events</a>
    <?php else: ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
                $eventId = (int)$row["id"];
                $category = htmlspecialchars($row["category"]);

                
                $badgeClass = "badge badge-default";
                switch (strtolower($category)) {
                    case "tech":   $badgeClass = "badge badge-tech"; break;
                    case "church": $badgeClass = "badge badge-church"; break;
                    case "sports": $badgeClass = "badge badge-sports"; break;
                    case "career": $badgeClass = "badge badge-career"; break;
                    default:       $badgeClass = "badge badge-default"; break;
                }
            ?>

            <div class="event-item">
                <div class="event-top">
                    <h3><?php echo htmlspecialchars($row["title"]); ?></h3>
                    <span class="<?php echo $badgeClass; ?>"><?php echo $category; ?></span>
                </div>

                <p><strong>Date:</strong> <?php echo htmlspecialchars($row["event_date"]); ?></p>
                <p><strong>Venue:</strong> <?php echo htmlspecialchars($row["venue"]); ?></p>
                <p><strong>Registered On:</strong> <?php echo htmlspecialchars($row["registered_at"]); ?></p>

                <form method="POST" action="my_registrations.php" onsubmit="return confirm('Cancel this registration?');">
                    <input type="hidden" name="cancel_event_id" value="<?php echo $eventId; ?>">
                    <button type="submit" class="btn-danger">Cancel</button>
                </form>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php endif; ?>
</section>

<?php
$stmt->close();
include "includes/footer.php";
?>