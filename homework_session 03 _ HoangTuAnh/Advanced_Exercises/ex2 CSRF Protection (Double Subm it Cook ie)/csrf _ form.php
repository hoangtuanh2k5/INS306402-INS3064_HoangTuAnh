<!DOCTYPE html>
<html>
<head>
    <title>🔒 CSRF Protection Form</title>
    <style>
        body{font-family:Arial; max-width:500px; margin:50px auto;}
        .error{background:#f8d7da; color:#721c24; padding:15px; border:1px solid #f5c6cb;}
        .success{background:#d4edda; color:#155724; padding:15px; border:1px solid #c3e6cb;}
    </style>
</head>
<body>
<?php
session_start();

// 1. TẠO TOKEN (nếu chưa có)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // 64 ký tự random
}
$token = $_SESSION['csrf_token'];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. KIỂM TRA TOKEN
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('❌ 403 Forbidden - CSRF Token không hợp lệ!');
    }
    
    // 3. TOKEN OK → xử lý form bình thường
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    
    $message = "
        ✅ CSRF TOKEN VALID!<br>
        Name: " . htmlspecialchars($name) . "<br>
        Email: " . htmlspecialchars($email);
    
    // TẠO TOKEN MỚI cho lần submit tiếp theo
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $token = $_SESSION['csrf_token'];
}
?>

<?php if ($message): ?>
    <div class="success"><?php echo $message; ?></div>
<?php endif; ?>

<h2>📝 Form An Toàn CSRF</h2>
<p><strong>Token hiện tại:</strong> <code><?php echo $token; ?></code></p>

<form method="POST">
    <div style="margin:20px 0;">
        <label>Tên:</label><br>
        <input type="text" name="name" style="width:100%; padding:8px;">
    </div>
    
    <div style="margin:20px 0;">
        <label>Email:</label><br>
        <input type="email" name="email" style="width:100%; padding:8px;">
    </div>
    
    <!-- HIDDEN CSRF TOKEN -->
    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
    
    <button type="submit" style="background:#007bff; color:white; padding:12px 24px; border:none;">
        🚀 Submit An Toàn
    </button>
</form>

<h3>🛡️ CSRF hoạt động thế nào?</h3>
<ul>
    <li>1️⃣ Tạo token random: <code>bin2hex(random_bytes(32))</code></li>
    <li>2️⃣ Lưu vào <code>$_SESSION['csrf_token']</code></li>
    <li>3️⃣ In vào form: <code>&lt;input type="hidden" name="csrf_token"&gt;</code></li>
    <li>4️⃣ Submit → so sánh <code>hash_equals()</code></li>
    <li>5️⃣ Sai → <code>die('403 Forbidden')</code></li>
</ul>

</body>
</html>
