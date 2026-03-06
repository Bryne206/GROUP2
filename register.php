<?php
require_once "includes/config.php";
include "includes/header.php";

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    
    $full_name = sanitize($_POST["full_name"] ?? "");
    $email     = sanitize($_POST["email"] ?? "");
    $phone     = sanitize($_POST["phone"] ?? "");
    $password  = $_POST["password"] ?? "";
    $confirm   = $_POST["confirm_password"] ?? "";

    
    if ($full_name === "" || $email === "" || $phone === "" || $password === "" || $confirm === "") {
        $errors[] = "All fields are required.";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Enter a valid email address.";
        }

        if ($password !== $confirm) {
            $errors[] = "Passwords do not match.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        }
    }

    
    $profilePath = null;

    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] !== UPLOAD_ERR_NO_FILE) {

        $file = $_FILES["profile_image"];

        
        if ($file["error"] !== UPLOAD_ERR_OK) {
            $errors[] = "Upload failed with error code: " . $file["error"];
        } else {

            
            $allowedExt = ["jpg", "jpeg", "png"];
            $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExt)) {
                $errors[] = "Only JPG, JPEG, and PNG images are allowed.";
            } elseif ($file["size"] > 2 * 1024 * 1024) {
                $errors[] = "Image too large. Max size is 2MB.";
            } else {

                
                $uploadDir = __DIR__ . "/uploads/profiles/";

                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                
                if (!is_writable($uploadDir)) {
                    $errors[] = "Upload folder is not writable: " . $uploadDir;
                } else {

                    
                    $newName = "profile_" . time() . "_" . rand(1000, 9999) . "." . $ext;

                    
                    $destination = $uploadDir . $newName;

                    
                    if (move_uploaded_file($file["tmp_name"], $destination)) {

                        
                        $profilePath = "uploads/profiles/" . $newName;

                    } else {
                        $errors[] = "Could not save uploaded image. (move_uploaded_file failed)";
                    }
                }
            }
        }
    }

    
    if (count($errors) === 0) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "This email is already registered. Try logging in.";
            $stmt->close();
        } else {
            $stmt->close();

            
            $stmt = $conn->prepare("
                INSERT INTO users (full_name, email, phone, password_hash, profile_image)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("sssss", $full_name, $email, $phone, $password_hash, $profilePath);

            if ($stmt->execute()) {
                $success = "Registration successful! You can now log in.";
            } else {
                $errors[] = "Database error: Could not register user.";
            }

            $stmt->close();
        }
    }
}
?>

<section class="card">
    <h2>Create Account</h2>

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

    <form action="register.php" method="POST" enctype="multipart/form-data">
        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <label>Profile Image (JPG/PNG, max 2MB)</label>
        <input type="file" name="profile_image" accept=".jpg,.jpeg,.png">

        <button type="submit">Register</button>
    </form>

    <p style="margin-top:12px;">
        Already have an account? <a href="login.php">Login</a>
    </p>
</section>

<?php include "includes/footer.php"; ?>