<?php
// CLI Migration Runner
require_once __DIR__ . '/../config/db.php';

try {
    echo "Connecting to MySQL server at " . DB_HOST . "...\n";
    $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $schemaFile = __DIR__ . '/schema.sql';
    echo "Reading schema from $schemaFile...\n";
    $sql = file_get_contents($schemaFile);

    echo "Executing schema...\n";
    $pdo->exec($sql);

    echo "✅ Success: Database `technicalbaba_db` installed and seeded successfully!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
