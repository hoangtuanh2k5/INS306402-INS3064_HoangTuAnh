<!DOCTYPE html>
<html>
<head>
    <title>🚨 Centralized Error Summary</title>
    <style>
        body{font-family:Arial; max-width:500px; margin:50px auto; padding:20px;}
        
        /* ERROR SUMMARY BOX - TOP */
        .error-summary {
            background:#f8d7da; 
            color:#721c24; 
            padding:20px; 
            border-radius:10px; 
            border-left:5px solid #dc3545;
            margin-bottom:30px;
        }
        
        /* FIELD ERROR HIGHLIGHT */
        .error-field {
            border:2px solid #dc3545 !important;
            background:#fff5f5;
        }
        
        .field {margin:20px 0;}
        label {display:block; font-weight:bold; margin-bottom:5px;}
        input, select {width:100%; padding:10px; box-sizing:border-box;}
        .success {background:#d4edda; color:#155724; padding:20px; border-radius:10px;}
    </style>
</head>
<body>
<h2>📋 Form với Error Summary</h2>

<?php
// 1. LẤY DỮ LIỆU FORM (sticky)
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$country = $_POST['country'] ?? '';
$age = $_POST['age'] ?? '';

// 2. MẢNG LƯU TẤT CẢ LỖI
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // VALIDATE NAME
    if (empty(trim($name))) {
        $errors[] = '❌ Tên không được để trống';
    }
    
    // VALIDATE EMAIL
    if (empty($email)) {
        $errors[] = '❌ Email không được để trống';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = '❌ Email không đúng định dạng';
    }
    
    // VALIDATE AGE
    if (empty($age)) {
        $errors[] = '❌ Tuổi không được để trống';
    } elseif (!is_numeric($age) || $age < 18 || $age > 100) {
        $errors[] = '❌ Tuổi phải từ 18-100';
    }
    
    // VALIDATE COUNTRY
    if (empty($country)) {
        $errors[] = '❌ Vui lòng chọn quốc gia';
    }
    
    // 3. NẾU KHÔNG CÓ LỖI → SUCCESS
    if (empty($errors)) {
        $success = true;
    }
}
?>

<?php if ($success): ?>
    <div class="success">
        <h2>🎉 Form hợp lệ!</h2>
        <p><strong>Tên:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Tuổi:</strong> <?php echo htmlspecialchars($age); ?></p>
        <p><strong>Quốc gia:</strong> <?php echo htmlspecialchars($country); ?></p>
    </div>
<?php else: ?>
    
    <?php if (!empty($errors)): ?>
        <!-- 4. ERROR SUMMARY BOX - TẬP TRUNG TOP -->
        <div class="error-summary">
            <h3>📋 Tìm thấy <?php echo count($errors); ?> lỗi:</h3>
            <ul style="margin:10px 0;">
                <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- 5. FORM với HIGHLIGHT ERROR FIELDS -->
    <form method="POST">
        <div class="field">
            <label>👤 Tên <?php echo empty(trim($name)) ? '<span style="color:red;">*</span>' : ''; ?>:</label>
            <input type="text" 
                   name="name" 
                   value="<?php echo htmlspecialchars($name); ?>"
                   class="<?php echo empty(trim($name)) ? 'error-field' : ''; ?>">
        </div>
        
        <div class="field">
            <label>📧 Email <?php echo empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ? '<span style="color:red;">*</span>' : ''; ?>:</label>
            <input type="email" 
                   name="email" 
                   value="<?php echo htmlspecialchars($email); ?>"
                   class="<?php echo empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ? 'error-field' : ''; ?>">
        </div>
        
        <div class="field">
            <label>🎂 Tuổi <?php echo (empty($age) || !is_numeric($age) || $age < 18 || $age > 100) ? '<span style="color:red;">*</span>' : ''; ?>:</label>
            <input type="number" 
                   name="age" 
                   value="<?php echo htmlspecialchars($age); ?>"
                   class="<?php echo (empty($age) || !is_numeric($age) || $age < 18 || $age > 100) ? 'error-field' : ''; ?>"
                   min="18" max="100">
        </div>
        
        <div class="field">
            <label>🌍 Quốc gia <?php echo empty($country) ? '<span style="color:red;">*</span>' : ''; ?>:</label>
            <select name="country" class="<?php echo empty($country) ? 'error-field' : ''; ?>">
                <option value="">Chọn quốc gia</option>
                <option value="VN" <?php echo $country=='VN' ? 'selected' : ''; ?>>Việt Nam</option>
                <option value="US" <?php echo $country=='US' ? 'selected' : ''; ?>>USA</option>
                <option value="JP" <?php echo $country=='JP' ? 'selected' : ''; ?>>Japan</option>
            </select>
        </div>
        
        <button type="submit" style="background:#007bff; color:white; padding:15px 30px; border:none; border-radius:5px; cursor:pointer;">
            🚀 Gửi Form
        </button>
    </form>
<?php endif; ?>

</body>
</html>
