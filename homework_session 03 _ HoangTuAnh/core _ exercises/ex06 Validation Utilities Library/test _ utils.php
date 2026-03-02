<?php
require_once 'utils.php';

echo "<h2>Kết quả kiểm tra</h2>";

// Kiểm tra từng hàm
echo "<h3>1. sanitize():</h3>";
$test1 = sanitize("<script>hack</script>");
echo "Input: <script>hack</script> → Output: " . $test1 . " → " . 
     (strpos($test1, '&lt;') !== false ? "<span style='color:green'>PASS</span>" : "<span style='color:red'>FAIL</span>") . "<br>";

echo "<h3>2. validateEmail():</h3>";
echo "user@test.com → " . (validateEmail('user@test.com') ? "<span style='color:green'>PASS</span>" : "<span style='color:red'>FAIL</span>") . "<br>";
echo "test@ → " . (validateEmail('test@') ? "<span style='color:green'>PASS</span>" : "<span style='color:red'>FAIL</span>") . "<br>";

echo "<h3>3. validateLength():</h3>";
echo "hello (5-10 ký tự) → " . (validateLength('hello', 5, 10) ? "<span style='color:green'>PASS</span>" : "<span style='color:red'>FAIL</span>") . "<br>";
echo "hi (5-10 ký tự) → " . (validateLength('hi', 5, 10) ? "<span style='color:green'>PASS</span>" : "<span style='color:red'>FAIL</span>") . "<br>";

echo "<h3>4. validatePassword():</h3>";
echo "Pass123! → " . (validatePassword('Pass123!') ? "<span style='color:green'>PASS</span>" : "<span style='color:red'>FAIL</span>") . "<br>";
echo "12345678 → " . (validatePassword('12345678') ? "<span style='color:green'>PASS</span>" : "<span style='color:red'>FAIL</span>") . "<br>";
?>
