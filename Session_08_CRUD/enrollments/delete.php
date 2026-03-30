<?php
require_once __DIR__ . '/../classes/Database.php';

$id = $_GET['id'];

$db = Database::getInstance();
$db->delete('enrollments', 'id = ?', [$id]);

header("Location: index.php");