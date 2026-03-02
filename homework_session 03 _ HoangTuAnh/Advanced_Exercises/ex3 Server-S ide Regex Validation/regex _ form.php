<!DOCTYPE html>
<html>
<head>
    <title>🔍 Regex Validation Form</title>
    <style>
        body{font-family:Arial; max-width:500px; margin:50px auto; padding:20px;}
        .error{background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin:10px 0;}
        .field{margin:15px 0;}
        label{display:inline-block; width:120px; font-weight:bold;}
        input{width:100%; padding:8px; box-sizing:border-box;}
        .pass-requirements{font-size:0.9em; color:#666;}
    </style>
</head>
<body>
<h2>📝 Đăng ký - Regex Validation</h2>

<?php
// Lấy dữ liệu form (giữ nguyên khi lỗi)
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. USERNAME: chỉ chữ + số (không ký tự đặc biệt)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $errors[] = '❌ Username: Chỉ dùng chữ cái và số (a-z, A-Z, 0-9)';
    }
    
    // 2. PASSWORD VALIDATION - 4 yêu cầu riêng biệt
    if (strlen($password) < 8) {
        $errors[] = '❌ Password: Ít nhất 8 ký tự';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = '❌ Password: Thiếu chữ HOA (A-Z)';
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = '❌ Password: Thiếu chữ thường (a-z)';
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = '❌ Password: Thiếu số (0-9)';
    }
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = '❌ Password: Thiếu ký tự đặc biệt (!@#$%^&*)';
    }
    
    // ✅ Nếu không lỗi
    if (empty($errors)) {
        echo "<div style='background:#d4edda; color:#155724; padding:20px; border-radius:10px;'>";
        echo "<h2>🎉 ĐĂNG KÝ THÀNH CÔNG!</h2>";
        echo "<p><strong>Username:</strong> " . htmlspecialchars($username) . "</p>";
        echo "<p><strong>Password:</strong> " . str_repeat('*', strlen($password)) . " (đã mã hóa)</p>";
        echo "</div>";
    }
}
?>

<?php if (!empty($errors)): ?>
    <div class="error">
        <h3>📋 Lỗi cụ thể:</h3>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="field">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        <small>Chỉ chữ + số (ví dụ: john123)</small>
    </div>
    
    <div class="field">
        <label>Password:</label>
        <input type="password" name="password" value="" required>
        <div class="pass-requirements">
            ✅ Yêu cầu: 8+ ký tự, 1 HOA, 1 thường, 1 số, 1 ký tự đặc biệt
        </div>
        <small>Ví dụ: Passw0rd!</small>
    </div>
    
    <button type="submit" style="background:#28a745; color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer;">
        🚀 Đăng ký
    </button>
</form>

<h3>🔧 Regex Patterns Giải thích:</h3>
<table border="1" style="width:100%; border-collapse:collapse; font-size:0.9em;">
    <tr><th>Trường</th><th>Regex</th><th>Ý nghĩa</th></tr>
    <tr><td>Username</td><td>`/^[a-zA-Z0-9]+$/`</td><td>Chỉ chữ+số, bắt đầu-kết thúc</td></tr>
    <tr><td>Password HOA</td><td>`/[A-Z]/`</td><td>Có ít nhất 1 chữ HOA</td></tr>
    <tr><td>Password số</td><td>`/[0-9]/`</td><td>Có ít nhất 1 số</td></tr>
    <tr><td>Password đặc biệt</td><td>`/[!@#$%^&*(),.?":{}|<>]/`</td><td>Có ít nhất 1 ký tự đặc biệt</td></tr>
</table>

</body>
</html>
