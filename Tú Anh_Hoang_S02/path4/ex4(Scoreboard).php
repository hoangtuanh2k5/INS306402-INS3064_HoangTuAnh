<?php
$scores = [60, 75, 80, 90, 70, 85];

// Tính tổng & trung bình
$sum = 0;
foreach ($scores as $s) {
    $sum += $s;
}
$avg = $sum / count($scores);

// Tìm max và min
$max = $scores[0];
$min = $scores[0];

foreach ($scores as $s) {
    if ($s > $max) $max = $s;
    if ($s < $min) $min = $s;
}

// Lọc điểm cao hơn trung bình
$topScores = [];
foreach ($scores as $s) {
    if ($s > $avg) {
        $topScores[] = $s;
    }
}

echo "Avg: " . round($avg, 2) . "<br>";
echo "Max: $max<br>";
echo "Min: $min<br>";
echo "Top: [" . implode(", ", $topScores) . "]";
?>
