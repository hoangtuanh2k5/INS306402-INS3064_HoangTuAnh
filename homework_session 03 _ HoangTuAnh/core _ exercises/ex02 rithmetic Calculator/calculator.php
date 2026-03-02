<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
</head>
<body>
<?php
$error = '';
$result = '';
$equation = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num1 = $_POST['num1'] ?? '';
    $num2 = $_POST['num2'] ?? '';
    $operation = $_POST['operation'] ?? '';
    
    // Validate numeric inputs using is_numeric()
    if (!is_numeric($num1) || !is_numeric($num2)) {
        $error = 'Both inputs must be numeric.';
    } elseif ($operation === 'divide' && $num2 == 0) {
        $error = 'Cannot divide by zero.';
    } else {
        // Convert to float for calculations
        $num1 = (float)$num1;
        $num2 = (float)$num2;
        
        switch ($operation) {
            case 'add':
                $result = $num1 + $num2;
                $equation = "$num1 + $num2";
                break;
            case 'subtract':
                $result = $num1 - $num2;
                $equation = "$num1 - $num2";
                break;
            case 'multiply':
                $result = $num1 * $num2;
                $equation = "$num1 * $num2";
                break;
            case 'divide':
                $result = $num1 / $num2;
                $equation = "$num1 / $num2";
                break;
        }
        $equation .= " = $result";
    }
}
?>

<?php if ($error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if ($result !== ''): ?>
    <p style="font-size: 1.2em; font-weight: bold;">
        <?php echo htmlspecialchars($equation); ?>
    </p>
<?php endif; ?>

<form method="POST">
    <label>First number: </label>
    <input type="number" name="num1" value="<?php echo htmlspecialchars($_POST['num1'] ?? ''); ?>" required><br><br>
    
    <label>Operation: </label>
    <select name="operation" required>
        <option value="">Select operation</option>
        <option value="add" <?php echo ($_POST['operation'] ?? '') === 'add' ? 'selected' : ''; ?>>+</option>
        <option value="subtract" <?php echo ($_POST['operation'] ?? '') === 'subtract' ? 'selected' : ''; ?>>-</option>
        <option value="multiply" <?php echo ($_POST['operation'] ?? '') === 'multiply' ? 'selected' : ''; ?>>×</option>
        <option value="divide" <?php echo ($_POST['operation'] ?? '') === 'divide' ? 'selected' : ''; ?>>÷</option>
    </select><br><br>
    
    <label>Second number: </label>
    <input type="number" name="num2" value="<?php echo htmlspecialchars($_POST['num2'] ?? ''); ?>" required><br><br>
    
    <button type="submit">Calculate</button>
</form>
</body>
</html>
