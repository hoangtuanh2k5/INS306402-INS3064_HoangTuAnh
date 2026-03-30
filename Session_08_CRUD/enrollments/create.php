<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$students = $db->fetchAll("SELECT id, name FROM students ORDER BY name");
$courses = $db->fetchAll("SELECT id, title FROM courses ORDER BY title");

$errors = [];
$student_id = 0;
$course_id = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = (int) ($_POST['student_id'] ?? 0);
    $course_id  = (int) ($_POST['course_id'] ?? 0);

    if ($student_id <= 0) {
        $errors['student'] = 'Vui lòng chọn sinh viên';
    }

    if ($course_id <= 0) {
        $errors['course'] = 'Vui lòng chọn khóa học';
    }

    if (empty($errors)) {
        try {
            // check trùng
            $exists = $db->fetch(
                "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?",
                [$student_id, $course_id]
            );

            if ($exists) {
                $errors['general'] = 'Đã đăng ký rồi';
            } else {
                $db->insert('enrollments', [
                    'student_id' => $student_id,
                    'course_id' => $course_id
                ]);

                header("Location: index.php?success=1");
                exit;
            }
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
    <title>Thêm đăng ký</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
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
                <h3 class="text-center mb-4">📝 Thêm đăng ký học</h3>

                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($errors['general']) ?>
                    </div>
                <?php endif; ?>

                <form method="post">

                    <!-- Student -->
                    <div class="mb-3">
                        <label class="form-label">Sinh viên</label>
                        <select 
                            name="student_id" 
                            class="form-select <?= !empty($errors['student']) ? 'is-invalid' : '' ?>"
                        >
                            <option value="0">-- Chọn sinh viên --</option>
                            <?php foreach ($students as $s): ?>
                                <option value="<?= $s['id'] ?>" <?= ($s['id'] == $student_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <?php if (!empty($errors['student'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['student']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Course -->
                    <div class="mb-3">
                        <label class="form-label">Khóa học</label>
                        <select 
                            name="course_id" 
                            class="form-select <?= !empty($errors['course']) ? 'is-invalid' : '' ?>"
                        >
                            <option value="0">-- Chọn khóa học --</option>
                            <?php foreach ($courses as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= ($c['id'] == $course_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <?php if (!empty($errors['course'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['course']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">← Quay lại</a>
                        <button type="submit" class="btn btn-danger">💾 Lưu đăng ký</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

</body>
</html>