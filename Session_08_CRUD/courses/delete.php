<?php
require_once __DIR__ . '/../classes/Database.php';

$id = $_GET['id'] ?? 0;

$db = Database::getInstance();
$db->delete('courses', 'id = ?', [$id]);

header('Location: index.php?deleted=1');