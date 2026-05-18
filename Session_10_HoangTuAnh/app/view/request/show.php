<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Detail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; color: #1f2937; }
        .card { border: 1px solid #d1d5db; border-radius: 8px; padding: 1rem; max-width: 720px; }
        dt { font-weight: bold; margin-top: 0.75rem; }
        dd { margin: 0.25rem 0 0; }
        a { color: #0f766e; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Request #<?= (int) $request->id ?></h1>

    <div class="card">
        <dl>
            <dt>Title</dt>
            <dd><?= htmlspecialchars($request->title, ENT_QUOTES, 'UTF-8') ?></dd>

            <dt>Description</dt>
            <dd><?= htmlspecialchars($request->description, ENT_QUOTES, 'UTF-8') ?></dd>

            <dt>Status</dt>
            <dd><?= htmlspecialchars($request->status, ENT_QUOTES, 'UTF-8') ?></dd>

            <dt>Created At</dt>
            <dd><?= htmlspecialchars($request->createdAt, ENT_QUOTES, 'UTF-8') ?></dd>
        </dl>
    </div>

    <p style="margin-top:1rem;"><a href="?action=index">Back to list</a></p>
</body>
</html>