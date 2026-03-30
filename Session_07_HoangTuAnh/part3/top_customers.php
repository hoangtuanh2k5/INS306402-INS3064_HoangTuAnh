<?php
require_once 'Database.php';

$db = Database::getInstance()->getConnection();

$sql = "SELECT users.name,
               users.email,
               SUM(orders.total_amount) AS total_spent
        FROM users
        JOIN orders ON users.id = orders.user_id
        GROUP BY users.id, users.name, users.email
        ORDER BY total_spent DESC
        LIMIT 3";

$stmt = $db->prepare($sql);
$stmt->execute();
$customers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Customers</title>
</head>
<body>
    <h2>Top 3 Customers</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Total Spent</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($customers)): ?>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['name']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                        <td><?php echo htmlspecialchars($customer['total_spent']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No data found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>