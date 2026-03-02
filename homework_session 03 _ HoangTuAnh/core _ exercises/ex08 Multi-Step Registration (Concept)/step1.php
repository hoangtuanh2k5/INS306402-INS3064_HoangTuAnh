<!DOCTYPE html>
<html>
<head>
    <title>Bước 1: Thông tin tài khoản</title>
    <style>body{font-family:Arial; max-width:500px; margin:50px auto;}</style>
</head>
<body>
<h2>📝 Bước 1/2: Thông tin tài khoản</h2>

<?php if ($_POST && isset($_POST['from_step1'])): ?>
    <?php 
    $user = htmlspecialchars($_POST['user']);
    $pass = htmlspecialchars($_POST['pass']);
    ?>
    <div style="background:#e8f5e8; padding:15px; border-radius:5px;">
        <h3>✅ Đã lưu thông tin tài khoản:</h3>
        <p><strong>User:</strong> <?php echo $user; ?></p>
        <p><strong>Pass:</strong> <?php echo substr($pass,0,3).'***'; ?></p>
    </div>
    <br>
<?php endif; ?>

<form method="POST" action="step2.php">
    <div style="margin:15px 0;">
        <label>👤 Username:</label><br>
        <input type="text" name="user" value="<?php echo htmlspecialchars($_POST['user']??''); ?>" required style="width:100%; padding:8px;">
    </div>
    
    <div style="margin:15px 0;">
        <label>🔒 Password:</label><br>
        <input type="password" name="pass" required style="width:100%; padding:8px;">
    </div>
    
    <button type="submit" style="background:#4CAF50; color:white; padding:12px 24px; border:none; cursor:pointer;">
        ➡️ Tiếp tục Bước 2
    </button>
    <input type="hidden" name="from_step1" value="1">
</form>
</body>
</html>
