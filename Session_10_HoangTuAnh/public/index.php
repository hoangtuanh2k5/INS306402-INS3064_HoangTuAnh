<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/app/controllers/RequestController.php';

$controller = new RequestController();
$action = $_GET['action'] ?? 'index';

if ($action === 'show') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false || $id === null) {
        http_response_code(400);
        echo 'Invalid request id.';
        exit;
    }

    $controller->show($id);
    exit;
}

if ($action === 'index' || $action === '') {
    $controller->index();
    exit;
}

http_response_code(404);
echo 'Route not found.';