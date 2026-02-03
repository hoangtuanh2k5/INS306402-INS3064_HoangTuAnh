<?php
// Initialize variables
$fullname = '';
$email = '';
$phone = '';
$message = '';
$submitted = false;
$missing_fields = [];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validate required fields
    if (empty($fullname)) {
        $missing_fields[] = 'Full Name';
    }
    if (empty($email)) {
        $missing_fields[] = 'Email';
    }
    if (empty($phone)) {
        $missing_fields[] = 'Phone Number';
    }
    if (empty($message)) {
        $missing_fields[] = 'Message';
    }

    // If no errors, mark as successfully submitted
    if (empty($missing_fields)) {
        $submitted = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Processing Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .error h2 {
            margin-top: 0;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 30px;
            border-radius: 4px;
            text-align: center;
        }
        .success h1 {
            color: #155724;
            font-size: 2.5em;
            margin: 0 0 10px 0;
        }
        .success p {
            font-size: 1.1em;
            margin: 10px 0;
        }
        .submitted-data {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .submitted-data h3 {
            color: #004085;
            margin-top: 0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        li:last-child {
            border-bottom: none;
        }
        strong {
            color: #333;
            min-width: 120px;
            display: inline-block;
        }
        .reset-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
        .reset-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($submitted): ?>
            <!-- Success Message - Form Disappears -->
            <div class="success">
                <h1>✓ Thank You!</h1>
                <p>Your message has been received successfully.</p>
                
                <div class="submitted-data">
                    <h3>Submitted Information:</h3>
                    <ul>
                        <li><strong>Full Name:</strong> <?php echo htmlspecialchars($fullname); ?></li>
                        <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                        <li><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone); ?></li>
                        <li><strong>Message:</strong> <?php echo htmlspecialchars($message); ?></li>
                    </ul>
                </div>

                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="reset-link">← Submit Another Message</a>
            </div>

        <?php else: ?>
            <!-- Form Display -->
            <h1>Contact Us</h1>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($missing_fields)): ?>
                <!-- Error Message -->
                <div class="error">
                    <h2>⚠️ Missing Data</h2>
                    <p>The following fields are required but were not filled in:</p>
                    <ul>
                        <?php foreach ($missing_fields as $field): ?>
                            <li>• <?php echo htmlspecialchars($field); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Contact Form -->
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required><?php echo htmlspecialchars($message); ?></textarea>
                </div>

                <button type="submit">Submit</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
