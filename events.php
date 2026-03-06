<?php
require_once "includes/config.php";
require_once "includes/auth.php";
include "includes/header.php";

$search = sanitize($_GET["search"] ?? "");
$cat = sanitize($_GET["category"] ?? "");

$user_id = (int)$_SESSION["user_id"];
$errors = [];
$success = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["event_id"])) {
    $event_id = (int)$_POST["event_id"];

    
    $stmt = $conn->prepare("SELECT id FROM registrations WHERE user_id = ? AND event_id = ?");
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "You already registered for this event.";
        $stmt->close();
    } else {
        $stmt->close();

    
        $stmt = $conn->prepare("
            SELECT e.capacity,
                   (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id) AS registered_count
            FROM events e
            WHERE e.id = ?
        ");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $capacity = (int)$row["capacity"];
            $registered_count = (int)$row["registered_count"];

            
            if ($registered_count >= $capacity) {
                $errors[] = "Event is full. Registration closed.";
            } else {
                
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $user_id, $event_id);

                if ($stmt->execute()) {
                    $success = "Registered successfully!";
                } else {
                    $errors[] = "Could not register. Try again.";
                }
            }
        } else {
            $errors[] = "Event not found.";
        }

        $stmt->close();
    }
}


$query = "
  SELECT e.*,
         (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id) AS registered_count
  FROM events e
  WHERE 1=1
";

$params = [];
$types = "";


if ($search !== "") {
    $query .= " AND e.title LIKE ? ";
    $params[] = "%" . $search . "%";
    $types .= "s";
}


if ($cat !== "" && $cat !== "all") {
    $query .= " AND e.category = ? ";
    $params[] = $cat;
    $types .= "s";
}

$query .= " ORDER BY e.event_date ASC ";

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();

$events = [];
while ($r = $res->fetch_assoc()) {
    $events[] = $r;
}
$stmt->close();
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $events[] = $r;
    }
}
?>

<section class="card">
    <h2>Available Events</h2>
    
    
    <form method="GET" action="events.php" class="filter-bar">

        <input 
            type="text" 
            name="search" 
            placeholder="Search events..."
            value="<?php echo htmlspecialchars($search); ?>"
        >

        <select name="category">
            <option value="all">All Categories</option>

            <option value="Tech" <?php if ($cat === "Tech") echo "selected"; ?>>Tech</option>
            <option value="Church" <?php if ($cat === "Church") echo "selected"; ?>>Church</option>
            <option value="Sports" <?php if ($cat === "Sports") echo "selected"; ?>>Sports</option>
            <option value="Career" <?php if ($cat === "Career") echo "selected"; ?>>Career</option>
        </select>

        <button type="submit">Filter</button>
    </form>

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

    <?php if (count($events) === 0): ?>
        <p>No events available yet.</p>
    <?php else: ?>
        <?php foreach ($events as $event): ?>
            <?php
                $event_id = (int)$event["id"];
                $title = htmlspecialchars($event["title"]);
                $venue = htmlspecialchars($event["venue"]);
                $category = htmlspecialchars($event["category"]);
                $date = htmlspecialchars($event["event_date"]);
                $capacity = (int)$event["capacity"];
                $registered_count = (int)$event["registered_count"];

                
                $badgeClass = "badge";
                switch (strtolower($category)) {
                    case "tech":
                        $badgeClass .= " badge-tech";
                        break;
                    case "church":
                        $badgeClass .= " badge-church";
                        break;
                    case "sports":
                        $badgeClass .= " badge-sports";
                        break;
                    case "career":
                        $badgeClass .= " badge-career";
                        break;
                    default:
                        $badgeClass .= " badge-default";
                        break;
                }

                $isFull = ($registered_count >= $capacity);
            ?>

            <div class="event-item">
                <div class="event-top">
                    <h3><?php echo $title; ?></h3>
                    <span class="<?php echo $badgeClass; ?>"><?php echo $category; ?></span>
                </div>

                <p><strong>Date:</strong> <?php echo $date; ?></p>
                <p><strong>Venue:</strong> <?php echo $venue; ?></p>
                <p><strong>Capacity:</strong> <?php echo $registered_count . " / " . $capacity; ?></p>

                <?php if ($isFull): ?>
                    <button disabled style="background:#9ca3af;">Full</button>
                <?php else: ?>
                    <form action="events.php" method="POST">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <button type="submit">Register</button>
                    </form>
                <?php endif; ?>
            </div>

            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php include "includes/footer.php"; ?>