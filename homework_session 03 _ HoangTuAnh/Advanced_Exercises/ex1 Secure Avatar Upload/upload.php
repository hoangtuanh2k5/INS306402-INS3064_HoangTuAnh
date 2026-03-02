<!DOCTYPE html>
<html>
<head>
    <title>🖼️ Upload Avatar An Toàn</title>
    <style>
        body{font-family:Arial; max-width:500px; margin:50px auto; padding:20px;}
        .success{background:#d4edda; color:#155724; padding:15px; border-radius:5px;}
        .error{background:#f8d7da; color:#721c24; padding:15px; border-radius:5px;}
        .info{background:#d1ecf1; color:#0c5460; padding:10px; border-radius:5px;}
    </style>
</head>
<body>
<h2>📸 Upload Avatar Profile</h2>

<?php
$message = '';
$uploaded_file = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    
    $file = $_FILES['avatar'];
    $name_input = $_POST['name'] ?? '';
    $email_input = $_POST['email'] ?? '';
    
    // 1. CHECK FILE ERRORS (UPLOAD ERRORS)
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $message = '❌ Lỗi upload: ' . $file['error'];
    } 
    // 2. VALIDATE MIME TYPE (chỉ jpg/png)
    elseif (!in_array($file['type'], ['image/jpeg', 'image/png'])) {
        $message = '❌ Chỉ chấp nhận JPEG/PNG!';
    } 
    // 3. VALIDATE SIZE (max 2MB = 2*1024*1024 bytes)
    elseif ($file['size'] > 2*1024*1024) {
        $message = '❌ File quá lớn! Max 2MB.';
    }
    // 4. TẠO uploads/ nếu chưa có
    elseif (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
        $message = '✅ Tạo thư mục uploads thành công. Thử lại!';
    }
    else {
        // 5. TÊN FILE DUY NHẤT = timestamp + random
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $unique_name = time() . '_' . uniqid() . '.' . $file_ext;
        $upload_path = 'uploads/' . $unique_name;
        
        // 6. MOVE FILE AN TOÀN
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            $uploaded_file = $upload_path;
            $message = '✅ Upload thành công! File: ' . $unique_name;
        } else {
            $message = '❌ Không thể lưu file. Check quyền thư mục!';
        }
    }
}
?>

<?php if ($message): ?>
    <div class="<?php echo strpos($message, '❌') === 0 ? 'error' : 'success'; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<?php if ($uploaded_file): ?>
    <div class="success">
        <h3>👤 Profile hoàn chỉnh:</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($_POST['name'] ?? ''); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email'] ?? ''); ?></p>
        <img src="<?php echo htmlspecialchars($uploaded_file); ?>" style="max-width:200px; border-radius:50%;">
        <p><strong>File:</strong> <?php echo htmlspecialchars($uploaded_file); ?></p>
    </div>
<?php endif; ?>

<div class="info">
    <strong>📋 Quy tắc:</strong> Chỉ JPG/PNG, max 2MB
</div>

<form method="POST" enctype="multipart/form-data">
    <div style="margin:20px 0;">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name']??''); ?>" required style="width:100%; padding:8px;">
    </div>
    
    <div style="margin:20px 0;">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email']??''); ?>" required style="width:100%; padding:8px;">
    </div>
    
    <div style="margin:20px 0;">
        <label>Avatar:</label><br>
        <input type="file" name="avatar" accept="image/jpeg,image/png" required style="width:100%; padding:8px;">
    </div>
    
    <button type="submit" style="background:#007bff; color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer;">
        🚀 Upload
    </button>
</form>

<?php if (is_dir('uploads')): ?>
    <h3>📁 Files đã upload:</h3>
    <?php 
    $files = glob('uploads/*.{jpg,jpeg,png}', GLOB_BRACE);
    if ($files): 
        foreach ($files as $f): ?>
            <div style="margin:10px 0;">
                <img src="<?php echo htmlspecialchars($f); ?>" style="width:100px; height:100px; object-fit:cover;">
                <?php echo htmlspecialchars(basename($f)); ?> 
                (<?php echo number_format(filesize($f)/1024,1); ?> KB)
            </div>
    <?php endforeach; 
    else: ?>
        <p>Chưa có file nào!</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
