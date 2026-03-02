<!DOCTYPE html>
<html>
<head>
    <title>Sticky Form - Giữ dữ liệu khi lỗi</title>
    <style>
        .error { color: red; font-weight: bold; }
        .field { margin: 10px 0; }
        input, select { padding: 5px; margin: 5px 0; }
        label { display: inline-block; width: 100px; }
    </style>
</head>
<body>
<?php
// Lấy dữ liệu từ form (không mất khi submit)
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$country = $_POST['country'] ?? '';
$gender = $_POST['gender'] ?? '';

// Mảng lỗi
$errors = [];
$success = false;

// Xử lý form khi submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate Name (bắt buộc)
    if (empty(trim($name))) {
        $errors[] = "Tên không được để trống";
    }
    
    // Validate Email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ";
    }
    
    // Validate Password - FORCE ERROR NHƯ YÊU CẦU
    if (strlen($password) < 3) {  // ← DELIBERATE ERROR: quá ngắn!
        $errors[] = "Password quá ngắn (cần ≥ 8 ký tự)";
    }
    
    // Nếu không có lỗi
    if (empty($errors)) {
        $success = true;
    }
}
?>

<?php if ($success): ?>
    <h2 style="color: green;">🎉 Form hợp lệ! Dữ liệu đã được gửi:</h2>
    <p>Tên: <?php echo htmlspecialchars($name); ?></p>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <p>Password: <?php echo htmlspecialchars($password); ?></p>
<?php else: ?>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <h3>❌ Lỗi:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <h2>📝 Form Đăng Ký (Dữ liệu không mất khi lỗi)</h2>
    <form method="POST" action="sticky.php">
        <div class="field">
            <label>Tên:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        </div>
        
        <div class="field">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        
        <div class="field">
            <label>Mật khẩu:</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <small>(Nhập dưới 3 ký tự để test lỗi)</small>
        </div>
        
        <div class="field">
            <label>Quốc gia:</label>
            <select name="country">
                <option value="">Chọn quốc gia</option>
                <option value="VN" <?php echo $country=='VN' ? 'selected' : ''; ?>>Việt Nam</option>
                <option value="US" <?php echo $country=='US' ? 'selected' : ''; ?>>USA</option>
                <option value="JP" <?php echo $country=='JP' ? 'selected' : ''; ?>>Japan</option>
            </select>
        </div>
        
        <div class="field">
            <label>Giới tính:</label>
            <input type="radio" name="gender" value="male" <?php echo $gender=='male' ? 'checked' : ''; ?>> Nam
            <input type="radio" name="gender" value="female" <?php echo $gender=='female' ? 'checked' : ''; ?>> Nữ
        </div>
        
        <div class="field">
            <button type="submit">Gửi Form</button>
        </div>
    </form>
<?php endif; ?>
</body>
</html>
