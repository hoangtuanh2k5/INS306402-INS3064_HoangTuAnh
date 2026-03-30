<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$sql = "SELECT e.id, s.name, c.title
        FROM enrollments e
        JOIN students s ON e.student_id = s.id
        JOIN courses c ON e.course_id = c.id
        ORDER BY e.id DESC";

$data = $db->fetchAll($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách đăng ký</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .card {
            border-radius: 15px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <div class="card shadow p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>📝 Danh sách đăng ký</h3>
            <a href="create.php" class="btn btn-success">+ Thêm đăng ký</a>
        </div>

        <!-- Table -->
        <table class="table table-bordered table-hover text-center align-middle">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>👨‍🎓 Sinh viên</th>
                    <th>📚 Khóa học</th>
                    <th>⚙️ Hành động</th>
                </tr>
            </thead>

            <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="4" class="text-muted">Chưa có dữ liệu</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>

                    <td>
                        <span class="badge bg-primary">
                            <?= htmlspecialchars($row['name']) ?>
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-info text-dark">
                            <?= htmlspecialchars($row['title']) ?>
                        </span>
                    </td>

                    <td>
                        <a 
                            href="delete.php?id=<?= $row['id'] ?>" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn chắc chắn muốn xóa đăng ký này?')"
                        >
                            🗑 Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>

    </div>

</div>

</body>
</html>