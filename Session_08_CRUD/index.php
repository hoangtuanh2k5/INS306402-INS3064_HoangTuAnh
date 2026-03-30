<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>School Management</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .container {
            margin-top: 80px;
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card a {
            text-decoration: none;
            color: white;
        }

        .card-body {
            padding: 40px;
        }

        .icon {
            font-size: 40px;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h1 class="mb-5">🎓 School Management System</h1>

    <div class="row g-4">

        <!-- Students -->
        <div class="col-md-4">
            <div class="card bg-primary shadow">
                <div class="card-body">
                    <div class="icon">👨‍🎓</div>
                    <h3 class="mt-3">Students</h3>
                    <p>Quản lý sinh viên</p>
                    <a href="students/index.php" class="btn btn-light mt-2">Go →</a>
                </div>
            </div>
        </div>

        <!-- Courses -->
        <div class="col-md-4">
            <div class="card bg-success shadow">
                <div class="card-body">
                    <div class="icon">📚</div>
                    <h3 class="mt-3">Courses</h3>
                    <p>Quản lý khóa học</p>
                    <a href="courses/index.php" class="btn btn-light mt-2">Go →</a>
                </div>
            </div>
        </div>

        <!-- Enrollments -->
        <div class="col-md-4">
            <div class="card bg-danger shadow">
                <div class="card-body">
                    <div class="icon">📝</div>
                    <h3 class="mt-3">Enrollments</h3>
                    <p>Quản lý đăng ký</p>
                    <a href="enrollments/index.php" class="btn btn-light mt-2">Go →</a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>