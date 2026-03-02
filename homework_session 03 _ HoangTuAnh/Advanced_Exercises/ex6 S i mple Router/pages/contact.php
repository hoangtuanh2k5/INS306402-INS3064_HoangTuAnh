<h2>📧 Contact Form</h2>
<p>Đây là trang Liên hệ. URL: <code>http://localhost/routing/?page=contact</code></p>
<hr>

<form method="POST">
    <p>
        <input type="text" name="name" placeholder="Tên của bạn" style="padding:8px; width:200px;">
        <input type="email" name="email" placeholder="Email" style="padding:8px; width:200px;">
    </p>
    <p>
        <textarea name="message" placeholder="Tin nhắn" rows="4" style="width:100%; padding:8px;"></textarea>
    </p>
    <button type="submit" style="background:#28a745; color:white; padding:10px 20px; border:none;">Gửi</button>
</form>

<?php if ($_POST): ?>
    <div style="background:#d4edda; padding:15px; margin-top:15px;">
        ✅ Nhận được: <?php echo htmlspecialchars($_POST['name'] ?? 'N/A'); ?>
    </div>
<?php endif; ?>
