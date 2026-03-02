<?php
/**
 * Sanitizes input data to prevent XSS attacks
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validates email format
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validates string length within min/max bounds
 */
function validateLength($str, $min, $max) {
    $length = strlen(trim($str));
    return $length >= $min && $length <= $max;
}

/**
 * Validates password (8+ chars, at least 1 special char)
 */
function validatePassword($pass) {
    return strlen($pass) >= 8 && 
           preg_match('/[!@#$%^&*(),.?":{}|<>]/', $pass);
}
?>
