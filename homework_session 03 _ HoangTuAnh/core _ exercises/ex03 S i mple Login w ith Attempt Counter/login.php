<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php
session_start();
$login_success = false;
$error = '';
$failed_attempts = 0;

// Initialize session counter if not exists
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Hardcoded credentials
    if ($username === 'admin' && $password === '123456') {
        $login_success = true;
        $_SESSION['logged_in'] = true;
        $_SESSION['failed_attempts'] = 0; // Reset counter on success
    } else {
        // Increment failed attempts counter
        $_SESSION['failed_attempts']++;
        $error = 'Invalid Credentials';
        $failed_attempts = $_SESSION['failed_attempts'];
    }
}
?>

<?php if ($login_success): ?>
    <h2 style="color: green;">Login Successful</h2>
<?php else: ?>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <?php if ($failed_attempts > 0): ?>
        <p>Failed Attempts: <?php echo $failed_attempts; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Username: </label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required><br><br>
        
        <label>Password: </label>
        <input type="password" name="password" required><br><br>
        
        <input type="hidden" name="failed_attempts" value="<?php echo $failed_attempts; ?>">
        <button type="submit">Login</button>
    </form>
<?php endif; ?>
</body>
</html>
