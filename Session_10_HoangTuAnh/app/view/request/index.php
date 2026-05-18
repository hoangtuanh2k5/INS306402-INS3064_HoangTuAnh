<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; color: #1f2937; }
        table { border-collapse: collapse; width: 100%; max-width: 900px; }
        th, td { border: 1px solid #d1d5db; padding: 10px; text-align: left; }
        th { background: #f3f4f6; }
        a { color: #0f766e; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Requests</h1>

    <?php if (empty($requests)): ?>
        <p>No requests found.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $item): ?>
                <tr>
                    <td><?= (int) $item->id ?></td>
                    <td><?= htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($item->status, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($item->createdAt, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><a href="?action=show&id=<?= (int) $item->id ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>