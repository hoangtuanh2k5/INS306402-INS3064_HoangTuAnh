<?php
function calculateBMI($kg, $m) {
    if ($m <= 0) {
        return "Invalid height";
    }

    $bmi = $kg / ($m * $m);
    $bmiRounded = round($bmi, 1);

    if ($bmi < 18.5) {
        $category = "Under";
    } elseif ($bmi < 25) {
        $category = "Normal";
    } else {
        $category = "Over";
    }

    return "BMI: $bmiRounded ($category)";
}

echo calculateBMI(68, 1.75);
?>
