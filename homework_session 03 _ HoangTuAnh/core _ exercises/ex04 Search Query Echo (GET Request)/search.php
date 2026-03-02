<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>
<?php
// Get search term from URL (?q=searchterm)
$query = $_GET['q'] ?? '';
?>

<?php if ($query): ?>
    <p style="color: green;">Searching for: "<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>"</p>
<?php endif; ?>

<form method="GET" action="search.php">
    <label>Search: </label>
    <input type="text" name="q" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter search term">
    <button type="submit">Search</button>
</form>

<?php if ($query): ?>
    <p><strong>Current URL:</strong> <code><?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></code></p>
<?php endif; ?>
</body>
</html>
