<?php
// =========================
// 1. KẾT NỐI CƠ SỞ DỮ LIỆU
// =========================

// Thông tin database trong XAMPP
$host = "localhost";              // máy chủ local
$dbname = "hospital_exam4";       // tên database
$username = "root";               // mặc định của XAMPP
$password = "";                   // mặc định thường để trống

try {
    // Tạo kết nối PDO đến MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Bật chế độ báo lỗi để dễ debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Nếu kết nối thất bại thì dừng chương trình và báo lỗi
    die("Database connection failed: " . $e->getMessage());
}

// =========================
// 2. KHAI BÁO BIẾN DÙNG CHUNG
// =========================

$errors = [];         // mảng lưu các lỗi validate / lỗi xử lý
$success = "";        // lưu thông báo thành công
$editPatient = null;  // lưu dữ liệu bệnh nhân khi bấm Edit


// =========================
// 3. XỬ LÝ DELETE
// =========================
// Nếu URL có dạng ?delete=3 thì sẽ xóa patient có id = 3

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];   // ép kiểu int để an toàn hơn

    try {
        // Dùng prepared statement để tránh SQL injection
        $stmt = $pdo->prepare("DELETE FROM patients WHERE id = ?");
        $stmt->execute([$id]);

        $success = "Patient deleted successfully.";
    } catch (PDOException $e) {
        $errors[] = "Delete failed: " . $e->getMessage();
    }
}


// =========================
// 4. LẤY DỮ LIỆU ĐỂ EDIT
// =========================
// Nếu URL có dạng ?edit=5 thì lấy dữ liệu patient id = 5 đưa lên form

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    $stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
    $stmt->execute([$id]);

    // fetch() lấy 1 dòng dữ liệu dưới dạng mảng kết hợp
    $editPatient = $stmt->fetch(PDO::FETCH_ASSOC);

    // Nếu không tìm thấy bệnh nhân
    if (!$editPatient) {
        $errors[] = "Patient not found.";
    }
}


// =========================
// 5. XỬ LÝ FORM ADD / UPDATE
// =========================
// Khi người dùng bấm nút submit form thì method sẽ là POST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Lấy dữ liệu từ form gửi lên
    $id = $_POST['id'] ?? '';   // nếu có id => đang update, nếu rỗng => add mới
    $patient_code = trim($_POST['patient_code'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $date_of_birth = trim($_POST['date_of_birth'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // =========================
    // 5.1 VALIDATION
    // =========================

    // Kiểm tra patient code có rỗng không
    if ($patient_code === '') {
        $errors[] = "Patient code is required.";
    }

    // Kiểm tra full name có rỗng không
    if ($full_name === '') {
        $errors[] = "Full name is required.";
    }

    // Kiểm tra gender có hợp lệ không
    if ($gender === '' || !in_array($gender, ['Male', 'Female', 'Other'])) {
        $errors[] = "Please select a valid gender.";
    }

    // Kiểm tra phone nếu có nhập thì phải đúng format cơ bản
    // regex này cho phép số, dấu +, dấu -, khoảng trắng, độ dài 8-20 ký tự
    if ($phone !== '' && !preg_match('/^[0-9+\-\s]{8,20}$/', $phone)) {
        $errors[] = "Phone number is invalid.";
    }

    // =========================
    // 5.2 KIỂM TRA patient_code CÓ BỊ TRÙNG KHÔNG
    // =========================

    if (empty($errors)) {

        if ($id) {
            // Trường hợp UPDATE:
            // kiểm tra có patient nào khác đang dùng cùng patient_code không
            $checkStmt = $pdo->prepare("SELECT id FROM patients WHERE patient_code = ? AND id != ?");
            $checkStmt->execute([$patient_code, $id]);

        } else {
            // Trường hợp ADD:
            // kiểm tra patient_code đã tồn tại chưa
            $checkStmt = $pdo->prepare("SELECT id FROM patients WHERE patient_code = ?");
            $checkStmt->execute([$patient_code]);
        }

        // Nếu có dữ liệu trả về => code đã tồn tại
        if ($checkStmt->fetch()) {
            $errors[] = "Patient code already exists.";
        }
    }

    // =========================
    // 5.3 LƯU DỮ LIỆU
    // =========================

    if (empty($errors)) {
        try {

            if ($id) {
                // =========================
                // UPDATE PATIENT
                // =========================
                $stmt = $pdo->prepare("
                    UPDATE patients
                    SET patient_code = ?, full_name = ?, date_of_birth = ?, gender = ?, phone = ?, address = ?
                    WHERE id = ?
                ");

                $stmt->execute([
                    $patient_code,
                    $full_name,
                    $date_of_birth ?: null,   // nếu rỗng thì lưu null
                    $gender,
                    $phone,
                    $address,
                    $id
                ]);

                $success = "Patient updated successfully.";

            } else {
                // =========================
                // INSERT PATIENT MỚI
                // =========================
                $stmt = $pdo->prepare("
                    INSERT INTO patients (patient_code, full_name, date_of_birth, gender, phone, address)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $patient_code,
                    $full_name,
                    $date_of_birth ?: null,
                    $gender,
                    $phone,
                    $address
                ]);

                $success = "Patient added successfully.";
            }

            // Sau khi lưu thành công thì reset chế độ edit
            $editPatient = null;

        } catch (PDOException $e) {
            $errors[] = "Save failed: " . $e->getMessage();
        }

    } else {
        // Nếu validate lỗi thì vẫn giữ lại dữ liệu người dùng đã nhập
        // để họ không phải nhập lại từ đầu
        $editPatient = [
            'id' => $id,
            'patient_code' => $patient_code,
            'full_name' => $full_name,
            'date_of_birth' => $date_of_birth,
            'gender' => $gender,
            'phone' => $phone,
            'address' => $address
        ];
    }
}


// =========================
// 6. LẤY DANH SÁCH PATIENTS ĐỂ HIỂN THỊ
// =========================

$stmt = $pdo->query("SELECT * FROM patients ORDER BY id DESC");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
// fetchAll() lấy toàn bộ dữ liệu thành mảng


// =========================
// 7. THỐNG KÊ DASHBOARD
// =========================

// Tổng số bệnh nhân = số dòng trong mảng $patients
$totalPatients = count($patients);

// Đếm tổng số cuộc hẹn trong bảng appointments
$totalAppointmentsStmt = $pdo->query("SELECT COUNT(*) FROM appointments");
$totalAppointments = $totalAppointmentsStmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Hỗ trợ responsive trên điện thoại -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Patient Dashboard</title>

    <style>
        /* Reset CSS cơ bản */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Nền và khoảng cách toàn trang */
        body {
            background: #f4f7fb;
            color: #333;
            padding: 20px;
        }

        /* Khung chính ở giữa */
        .container {
            max-width: 1100px;
            margin: auto;
        }

        /* Tiêu đề chính */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #1d4ed8;
        }

        /* Khu vực 2 card thống kê */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        /* Từng card */
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin-bottom: 8px;
            color: #555;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #1d4ed8;
        }

        /* Box của form và bảng */
        .form-box, .table-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .form-box h2, .table-box h2 {
            margin-bottom: 15px;
            color: #1f2937;
        }

        /* Thông báo thành công / lỗi */
        .message {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Chia form thành nhiều cột */
        form .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        form .form-group {
            margin-bottom: 15px;
        }

        /* Label */
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        /* Input, select */
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Nút dùng chung */
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
        }

        /* Nút Add / Update */
        .btn-primary {
            background: #2563eb;
            color: white;
        }

        /* Nút Edit */
        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        /* Nút Delete */
        .btn-danger {
            background: #dc2626;
            color: white;
        }

        /* Nút Cancel */
        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        /* Bảng dữ liệu */
        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        table th {
            background: #eff6ff;
        }

        /* Nếu màn hình nhỏ thì bảng có thể kéo ngang */
        .table-wrapper {
            overflow-x: auto;
        }

        /* Responsive cho mobile */
        @media (max-width: 768px) {
            .btn {
                margin-bottom: 8px;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <!-- TIÊU ĐỀ CHÍNH -->
    <h1>Hospital Patient Appointment Management System</h1>

    <!-- CARD THỐNG KÊ -->
    <div class="cards">
        <div class="card">
            <h3>Total Patients</h3>
            <p><?php echo $totalPatients; ?></p>
        </div>

        <div class="card">
            <h3>Total Appointments</h3>
            <p><?php echo $totalAppointments; ?></p>
        </div>
    </div>

    <!-- FORM ADD / EDIT -->
    <div class="form-box">

        <!-- Nếu đang edit thì hiện "Edit Patient", không thì hiện "Add New Patient" -->
        <h2><?php echo $editPatient ? 'Edit Patient' : 'Add New Patient'; ?></h2>

        <!-- Hiện thông báo thành công -->
        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Hiện danh sách lỗi -->
        <?php if (!empty($errors)): ?>
            <div class="message error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <!-- input ẩn để biết đang edit id nào -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($editPatient['id'] ?? ''); ?>">

            <div class="row">

                <div class="form-group">
                    <label>Patient Code</label>
                    <input
                        type="text"
                        name="patient_code"
                        maxlength="20"
                        value="<?php echo htmlspecialchars($editPatient['patient_code'] ?? ''); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input
                        type="text"
                        name="full_name"
                        maxlength="100"
                        value="<?php echo htmlspecialchars($editPatient['full_name'] ?? ''); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input
                        type="date"
                        name="date_of_birth"
                        value="<?php echo htmlspecialchars($editPatient['date_of_birth'] ?? ''); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="">-- Select Gender --</option>

                        <!-- Nếu dữ liệu hiện tại là Male thì selected -->
                        <option value="Male" <?php echo (($editPatient['gender'] ?? '') === 'Male') ? 'selected' : ''; ?>>
                            Male
                        </option>

                        <option value="Female" <?php echo (($editPatient['gender'] ?? '') === 'Female') ? 'selected' : ''; ?>>
                            Female
                        </option>

                        <option value="Other" <?php echo (($editPatient['gender'] ?? '') === 'Other') ? 'selected' : ''; ?>>
                            Other
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input
                        type="text"
                        name="phone"
                        maxlength="20"
                        value="<?php echo htmlspecialchars($editPatient['phone'] ?? ''); ?>"
                    >
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input
                        type="text"
                        name="address"
                        maxlength="200"
                        value="<?php echo htmlspecialchars($editPatient['address'] ?? ''); ?>"
                    >
                </div>
            </div>

            <!-- Nút submit: nếu edit thì hiện Update, không thì Add -->
            <button type="submit" class="btn btn-primary">
                <?php echo $editPatient ? 'Update Patient' : 'Add Patient'; ?>
            </button>

            <!-- Chỉ hiện nút Cancel khi đang ở chế độ edit -->
            <?php if ($editPatient): ?>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- BẢNG DANH SÁCH PATIENT -->
    <div class="table-box">
        <h2>Patient List</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Code</th>
                        <th>Full Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (!empty($patients)): ?>

                    <!-- Duyệt từng patient trong danh sách -->
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo $patient['id']; ?></td>
                            <td><?php echo htmlspecialchars($patient['patient_code']); ?></td>
                            <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($patient['date_of_birth']); ?></td>
                            <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                            <td><?php echo htmlspecialchars($patient['address']); ?></td>
                            <td>
                                <!-- Nút Edit: truyền id qua URL -->
                                <a class="btn btn-warning" href="?edit=<?php echo $patient['id']; ?>">Edit</a>

                                <!-- Nút Delete: truyền id qua URL -->
                                <a class="btn btn-danger"
                                   href="?delete=<?php echo $patient['id']; ?>"
                                   onclick="return confirm('Are you sure you want to delete this patient?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <!-- Nếu không có dữ liệu -->
                    <tr>
                        <td colspan="8">No patient records found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>