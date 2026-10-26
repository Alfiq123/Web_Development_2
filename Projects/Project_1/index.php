<?php
// Initialize variables to clear form values and error arrays
$name           = $email = $message = "";
$errors         = [];
$successMessage = "";

// Check if the form has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Sanitize string inputs to prevent XSS attacks
    $name    = htmlspecialchars(trim($_POST['name']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // 2. Validate Email using built-in filters
    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required.";
    } else {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
    }

    // 3. Check other required fields
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }
    if (empty($message)) {
        $errors['message'] = "Message cannot be empty.";
    }

    // 4. Action processing if no validation errors exist
    if (empty($errors)) {
        // Here you would normally send an email or store this in a database
        $successMessage = "Thank you, $name! Your message has been sent successfully.";
        
        // Reset form variables upon successful processing
        $name = $email  = $message = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Contact Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background: #f9f9f9; }
        .form-container { background: #fff; padding: 25px; border-radius: 5px; max-width: 400px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .error { color: red; font-size: 14px; margin-bottom: 5px; }
        .success { color: green; font-weight: bold; margin-bottom: 15px; }
        .field { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background: #007BFF; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 3px; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Contact Us</h2>
    
    <?php if (!empty($successMessage)): ?>
        <div class="success"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <div class="field">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4"><?php echo $message; ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <div class="error"><?php echo $errors['message']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Send Message</button>
    </form>
</div>

</body>
</html>
