<?php
require_once "includes/config.php";
include "includes/header.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = sanitize($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $errors[] = "Email and password are required.";
    } else {

        $stmt = $conn->prepare("SELECT id, full_name, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            
            if (password_verify($password, $user["password_hash"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["full_name"] = $user["full_name"];

                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Invalid email or password.";
            }
        } else {
            $errors[] = "Invalid email or password.";
        }

        $stmt->close();
    }
}
?>

<section class="card">
  <h2>Login</h2>

  <?php if (!empty($errors)): ?>
    <div class="error">
      <ul>
        <?php foreach($errors as $e): ?>
          <li><?php echo $e; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>

  <p style="margin-top:12px;">
    New user? <a href="register.php">Create an account</a>
  </p>
</section>

<?php include "includes/footer.php"; ?>