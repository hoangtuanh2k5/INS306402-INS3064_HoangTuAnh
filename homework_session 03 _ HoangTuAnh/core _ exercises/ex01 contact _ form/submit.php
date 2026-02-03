<?php
// Get form data
$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Check for missing data
$missing_fields = [];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Result</title>
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
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success h2 {
            margin-top: 0;
            color: #155724;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        li:last-child {
            border-bottom: none;
        }
        strong {
            color: #333;
            min-width: 120px;
            display: inline-block;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($missing_fields)): ?>
            <div class="error">
                <h2>⚠️ Missing Data</h2>
                <p>The following fields are required but were not filled in:</p>
                <ul>
                    <?php foreach ($missing_fields as $field): ?>
                        <li>• <?php echo htmlspecialchars($field); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="success">
                <h2>✓ Form Submitted Successfully</h2>
                <p>Thank you! Your information has been received.</p>
            </div>
            
            <h3>Submitted Information:</h3>
            <ul>
                <li><strong>Full Name:</strong> <?php echo htmlspecialchars($fullname); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                <li><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone); ?></li>
                <li><strong>Message:</strong> <?php echo htmlspecialchars($message); ?></li>
            </ul>
        <?php endif; ?>

        <a href="contact.html" class="back-link">← Back to Form</a>
    </div>
</body>
</html>
