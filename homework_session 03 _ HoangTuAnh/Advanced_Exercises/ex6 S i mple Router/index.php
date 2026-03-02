<!DOCTYPE html>
<html>
<head>
    <title>🏠 Simple PHP Router</title>
    <style>
        body{font-family:Arial; max-width:800px; margin:50px auto; padding:20px;}
        nav{background:#007bff; padding:15px; border-radius:5px;}
        nav a{color:white; margin:0 15px; text-decoration:none; padding:8px 15px; border-radius:3px;}
        nav a.active, nav a:hover{background:#0056b3;}
        .page-content{padding:30px; background:#f8f9fa; border-radius:10px; margin-top:20px;}
        .error-404{background:#f8d7da; color:#721c24; padding:40px; text-align:center; border-radius:10px;}
    </style>
</head>
<body>

<?php
// 1. LẤY PAGE TỪ URL (?page=home)
$page = $_GET['page'] ?? 'home';

// 2. VALIDATE & SANITIZE PAGE NAME
$allowed_pages = ['home', 'about', 'contact'];
if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

// 3. FRONT CONTROLLER - INCLUDE FILE
$page_file = "pages/{$page}.php";
?>

<!-- 4. NAVIGATION -->
<nav>
    <a href="?page=home" class="<?php echo $page=='home' ? 'active' : ''; ?>">🏠 Home</a>
    <a href="?page=about" class="<?php echo $page=='about' ? 'active' : ''; ?>">ℹ️ About</a>
    <a href="?page=contact" class="<?php echo $page=='contact' ? 'active' : ''; ?>">📧 Contact</a>
</nav>

<!-- 5. CONTENT DYNAMIC -->
<div class="page-content">
    <?php if (file_exists($page_file)): ?>
        <?php include $page_file; ?>
    <?php else: ?>
        <div class="error-404">
            <h1>❌ 404 - Page Not Found</h1>
            <p>Trang "<?php echo htmlspecialchars($page); ?>" không tồn tại!</p>
            <a href="?page=home" style="color:#007bff;">← Quay về Home</a>
        </div>
    <?php endif; ?>
</div>

<!-- 6. DEBUG INFO -->
<div style="font-size:0.8em; color:#666; margin-top:30px;">
    <strong>Debug:</strong> 
    URL: <code><?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></code> | 
    Page: <code><?php echo $page; ?></code> | 
    File: <code><?php echo $page_file; ?></code>
</div>

</body>
</html>
