<?php

use Firebase\JWT\JWT;

require 'vendor/autoload.php';

// Input password to test
$inputPassword = 'password123';

// Hash the password
$hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

// Output hashed password
echo 'Hashed Password: ' . $hashedPassword . PHP_EOL;

// Verify the password
if (password_verify($inputPassword, $hashedPassword)) {
    echo 'Password verification successful' . PHP_EOL;
} else {
    echo 'Password verification failed' . PHP_EOL;
}

// Output input password and hashed password for debugging
echo 'Input Password: ' . $inputPassword . PHP_EOL;
echo 'Hashed Password: ' . $hashedPassword . PHP_EOL;
