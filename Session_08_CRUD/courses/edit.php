<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = $_GET['id'] ?? 0;

try {
    $course = $db->fetch("SELECT * FROM courses WHERE id = ?", [$id]);

    if (!$course) {
        throw new Exception("Không tìm thấy khóa học");
    }
} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}

$title = $course['title'];
$description = $course['description'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '') {
        $errors['title'] = 'Không được để trống';
    } elseif (strlen($title) < 3) {
        $errors['title'] = 'Tối thiểu 3 ký tự';
    }

    if (empty($errors)) {
        try {
            $db->update('courses', [
                'title' => $title,
                'description' => $description
            ], 'id = ?', [$id]);

            header('Location: index.php?updated=1');
            exit;
        } catch (Exception $e) {
            $errors['general'] = 'Lỗi hệ thống';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa khóa học</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        .card {
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow p-4">
                <h3 class="text-center mb-4">✏️ Sửa khóa học</h3>

                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($errors['general']) ?>
                    </div>
                <?php endif; ?>

                <form method="post">

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Tên khóa học</label>
                        <input 
                            type="text" 
                            name="title" 
                            class="form-control <?= !empty($errors['title']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($title) ?>"
                        >
                        <?php if (!empty($errors['title'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['title']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea 
                            name="description" 
                            class="form-control" 
                            rows="4"
                        ><?= htmlspecialchars($description) ?></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">← Quay lại</a>
                        <button type="submit" class="btn btn-success">✔️ Cập nhật</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

</body>
</html>