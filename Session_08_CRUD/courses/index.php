<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();
$courses = $db->fetchAll('SELECT * FROM courses ORDER BY created_at DESC');

$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = 'Thêm khóa học thành công!';
} elseif (isset($_GET['updated'])) {
    $successMessage = 'Cập nhật thành công!';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Xóa thành công!';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Courses</title>

<style>
body {
    font-family: Arial;
    background: #f5f6fa;
    margin: 0;
}

.container {
    width: 80%;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

h1 {
    margin-bottom: 20px;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn {
    padding: 8px 15px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-size: 14px;
}

.btn-add { background: #2ecc71; }
.btn-edit { background: #3498db; }
.btn-delete { background: #e74c3c; }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th {
    background: #2c3e50;
    color: white;
    padding: 10px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background: #f1f1f1;
}

.message {
    padding: 10px;
    background: #dff0d8;
    color: #2e7d32;
    border-radius: 5px;
    margin-bottom: 10px;
}
</style>

</head>

<body>

<div class="container">

<div class="top-bar">
    <h1>📚 Quản lý khóa học</h1>
    <a href="create.php" class="btn btn-add">+ Thêm khóa học</a>
</div>

<?php if ($successMessage): ?>
    <div class="message"><?= $successMessage ?></div>
<?php endif; ?>

<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Action</th>
</tr>

<?php foreach ($courses as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= htmlspecialchars($c['title']) ?></td>
    <td><?= htmlspecialchars($c['description']) ?></td>
    <td>
        <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-edit">Sửa</a>
        <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-delete"
           onclick="return confirm('Xóa khóa học này?')">Xóa</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</div>

</body>
</html>