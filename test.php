<?php

require_once __DIR__ . '/src/PhoneValidator.php';

// API anahtarınızı buraya girin
$apiKey = 'YOUR_API_KEY_HERE';

$validator = new PhoneValidator($apiKey);

// Test edilecek telefon numarası
$testNumber = '+14155552671'; // Örnek: ABD numarası
$testAddress = 'US'; // Opsiyonel: ülke veya tam adres

try {
    $result = $validator->validate($testNumber, $testAddress);
    echo "✅ Validation result:\n";
    print_r($result);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
