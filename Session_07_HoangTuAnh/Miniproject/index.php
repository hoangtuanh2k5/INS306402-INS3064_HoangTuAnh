<?php
require_once "Database.php";

// Create database connection
$database = new Database();
$conn = $database->connect();

// Get user input safely
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_id = isset($_GET['category_id']) ? trim($_GET['category_id']) : '';

// ===============================
// 1. LOAD CATEGORY LIST
// This is used to populate the <select> dropdown
// ===============================
$categorySql = "SELECT id, category_name FROM categories ORDER BY category_name ASC";
$categoryStmt = $conn->prepare($categorySql);
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// ===============================
// 2. MAIN PRODUCT QUERY
// We use JOIN because the requirement asks to display Category Name
// from the categories table together with product data.
// ===============================
$sql = "SELECT 
            products.id,
            products.name,
            products.price,
            categories.category_name,
            products.stock
        FROM products
        INNER JOIN categories ON products.category_id = categories.id
        WHERE 1=1";

// Array to store parameters for prepared statement
$params = [];

// Dynamic search by product name
if (!empty($search)) {
    $sql .= " AND products.name LIKE :search";
    $params[':search'] = "%" . $search . "%";
}

// Filter by category
if (!empty($category_id)) {
    $sql .= " AND products.category_id = :category_id";
    $params[':category_id'] = $category_id;
}

$sql .= " ORDER BY products.id ASC";

// Prepare and execute query
$stmt = $conn->prepare($sql);
$stmt->execute($params);

// Fetch all matching products
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Administration Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f7f7f7;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0,0,0,0.08);
        }

        input, select, button {
            padding: 8px 12px;
            margin-right: 10px;
            margin-top: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 6px rgba(0,0,0,0.08);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        .low-stock {
            background-color: #ffcccc;
            color: #900;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>

    <h1>Product Administration Dashboard</h1>

    <!-- 
        Search + Category Filter Form
        Method GET is suitable because we are only filtering/displaying data,
        not changing data in the database.
    -->
    <form method="GET" action="">
        <input 
            type="text" 
            name="search" 
            placeholder="Search product name..." 
            value="<?php echo htmlspecialchars($search); ?>"
        >

        <select name="category_id">
            <option value="">-- All Categories --</option>
            <?php foreach ($categories as $category): ?>
                <option 
                    value="<?php echo $category['id']; ?>"
                    <?php echo ($category_id == $category['id']) ? 'selected' : ''; ?>
                >
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Filter</button>
        <a href="index.php" style="text-decoration:none;">
            <button type="button">Reset</button>
        </a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category Name</th>
                <th>Stock Level</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <tr class="<?php echo ($product['stock'] < 10) ? 'low-stock' : ''; ?>">
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="no-data">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>