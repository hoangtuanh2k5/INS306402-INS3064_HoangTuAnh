<!DOCTYPE html>
<html>
<head>
    <title>🔄 GET vs POST Toggle</title>
    <style>
        body{font-family:Arial; max-width:600px; margin:50px auto; padding:20px;}
        .method-box{background:#f8f9fa; padding:15px; border-radius:5px; margin:15px 0;}
        .get-method{color:#007bff;}
        .post-method{color:#28a745;}
        pre{background:#e9ecef; padding:15px; border-radius:5px; font-size:0.9em;}
        .active{background:#007bff33 !important;}
    </style>
</head>
<body>
<h2>📡 GET vs POST - Chọn phương thức gửi</h2>

<?php
// 1. PHÁT HIỆN METHOD ĐƯỢC SỬ DỤNG
$request_method = $_SERVER['REQUEST_METHOD'];
$data = [];

if ($request_method === 'GET') {
    $data = $_GET;
    $method_used = 'GET';
    $method_color = 'get-method';
} else {
    $data = $_POST;
    $method_used = 'POST';
    $method_color = 'post-method';
}

// 2. LẤY DỮ LIỆU FORM (sticky)
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
?>

<?php if ($request_method !== 'GET' && $request_method !== 'POST'): ?>
    <!-- FORM CHƯA SUBMIT -->
<?php else: ?>
    <div class="method-box <?php echo $method_color; ?>">
        <h3>✅ Nhận dữ liệu qua <strong><?php echo strtoupper($method_used); ?></strong></h3>
        <p>Array: <code><?php echo htmlspecialchars(print_r($data, true)); ?></code></p>
        
        <?php if ($name): ?>
            <div style="margin:15px 0;">
                <strong>Name:</strong> <?php echo htmlspecialchars($name); ?><br>
                <strong>Email:</strong> <?php echo htmlspecialchars($email); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<h3>📝 Form Test (Chọn method bên dưới)</h3>

<form id="testForm" method="GET" action="method_toggle.php">
    <div style="margin:20px 0;">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" style="width:100%; padding:8px;">
    </div>
    
    <div style="margin:20px 0;">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" style="width:100%; padding:8px;">
    </div>
    
    <!-- RADIO BUTTON CHUYỂN METHOD -->
    <div style="margin:20px 0; padding:15px; background:#f0f8ff; border-radius:5px;">
        <label style="display:block; margin:10px 0;">
            <input type="radio" name="method" value="get" id="get" checked onclick="setMethod('GET')">
            <span class="get-method">📡 GET (URL: ?name=abc&email=xyz)</span>
        </label>
        <label style="display:block; margin:10px 0;">
            <input type="radio" name="method" value="post" id="post" onclick="setMethod('POST')">
            <span class="post-method">📬 POST (Ẩn trong request body)</span>
        </label>
    </div>
    
    <button type="submit" style="background:#28a745; color:white; padding:12px 30px; border:none; border-radius:5px;">
        🚀 Gửi Form
    </button>
</form>

<script>
// JAVASCRIPT ĐỔI METHOD DYNAMICALLY
function setMethod(method) {
    const form = document.getElementById('testForm');
    form.method = method;
    
    // Visual feedback
    document.querySelectorAll('input[name="method"]').forEach(radio => {
        radio.parentElement.classList.toggle('active', radio.checked);
    });
}
</script>

<h3>📊 So sánh GET vs POST</h3>
<table border="1" style="width:100%; border-collapse:collapse; font-size:0.9em;">
    <tr><th>Tiêu chí</th><th>GET</th><th>POST</th></tr>
    <tr><td>Superglobal</td><td>$_GET</td><td>$_POST</td></tr>
    <tr><td>URL</td><td><code>?name=abc</code></td><td>Ẩn</td></tr>
    <tr><td>Phát hiện</td><td><?php echo $_SERVER['REQUEST_METHOD'] === 'GET' ? '🟢 Đang dùng' : '🔴'; ?></td><td><?php echo $_SERVER['REQUEST_METHOD'] === 'POST' ? '🟢 Đang dùng' : '🔴'; ?></td></tr>
    <tr><td>Dữ liệu</td><td style="font-family:monospace;"><?php echo htmlspecialchars(print_r($_GET, true)); ?></td><td style="font-family:monospace;"><?php echo htmlspecialchars(print_r($_POST, true)); ?></td></tr>
</table>

</body>
</html>
