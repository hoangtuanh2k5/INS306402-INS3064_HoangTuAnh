<?php
$students = [
    ['name' => 'Alice', 'grade' => 90],
    ['name' => 'Bob', 'grade' => 85],
    ['name' => 'Charlie', 'grade' => 92]
];

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Name</th><th>Grade</th></tr>";

foreach ($students as $student) {
    echo "<tr>";
    echo "<td>" . $student['name'] . "</td>";
    echo "<td>" . $student['grade'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
