<!DOCTYPE html>
<html>
<head>
    <title>Bước 2: Thông tin cá nhân</title>
    <style>body{font-family:Arial; max-width:500px; margin:50px auto;}</style>
</head>
<body>
<?php
// Lấy dữ liệu từ step1
$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';
$bio = $_POST['bio'] ?? '';
$location = $_POST['location'] ?? '';
?>

<h2>📝 Bước 2/2: Thông tin cá nhân</h2>

<?php if ($user): ?>
<div style="background:#e8f5e8; padding:15px; border-radius:5px; margin-bottom:20px;">
    <h3>📋 Đã có từ Bước 1:</h3>
    <p><strong>User:</strong> <?php echo htmlspecialchars($user); ?></p>
    <p><strong>Pass:</strong> <?php echo substr(htmlspecialchars($pass),0,3).'***'; ?></p>
</div>
<?php endif; ?>

<form method="POST" action="step2.php">
    <div style="margin:15px 0;">
        <label>✍️ Bio:</label><br>
        <textarea name="bio" rows="3" style="width:100%; padding:8px;"><?php echo htmlspecialchars($bio); ?></textarea>
    </div>
    
    <div style="margin:15px 0;">
        <label>📍 Location:</label><br>
        <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" placeholder="Hà Nội, Việt Nam" style="width:100%; padding:8px;">
    </div>
    
    <!-- HIDDEN FIELDS: Pass dữ liệu step1 sang final -->
    <input type="hidden" name="user" value="<?php echo htmlspecialchars($user); ?>">
    <input type="hidden" name="pass" value="<?php echo htmlspecialchars($pass); ?>">
    
    <button type="submit" name="submit_final" value="1" style="background:#2196F3; color:white; padding:12px 24px; border:none; cursor:pointer;">
        ✅ Hoàn thành & Xem kết quả
    </button>
</form>

<?php
// FINAL SUBMISSION - Hiển thị TẤT CẢ dữ liệu
if (isset($_POST['submit_final'])): ?>
    <div style="background:#d4edda; border:2px solid #28a745; padding:20px; margin:20px 0; border-radius:10px;">
        <h2>🎉 HOÀN THÀNH! Tất cả dữ liệu:</h2>
        <h3>📱 Tài khoản:</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user); ?></p>
        <p><strong>Password:</strong> <?php echo htmlspecialchars($pass); ?></p>
        
        <h3>👤 Cá nhân:</h3>
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($bio) ?: 'Chưa nhập'; ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($location) ?: 'Chưa nhập'; ?></p>
        
        <p style="color:#28a745; font-size:1.2em;">✅ Thu thập thành công từ 2 bước!</p>
    </div>
<?php endif; ?>

</body>
</html>
