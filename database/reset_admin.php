<?php
require_once __DIR__ . '/../config/db.php';

try {
    $db = getDB();
    $password = 'admin@123';
    $hash = password_hash($password, PASSWORD_BCRYPT);
    
    // Check if admin exists
    $stmt = $db->prepare("SELECT id FROM admin_users WHERE username = 'admin'");
    $stmt->execute();
    $row = $stmt->fetch();

    if ($row) {
        $update = $db->prepare("UPDATE admin_users SET password = ?, email = 'admin@technicalbaba.com', full_name = 'Technical Baba Admin' WHERE id = ?");
        $update->execute([$hash, $row['id']]);
        echo "✅ Admin password reset to '$password' successfully! (ID: {$row['id']})\n";
    } else {
        $insert = $db->prepare("INSERT INTO admin_users (username, password, email, full_name) VALUES ('admin', ?, 'admin@technicalbaba.com', 'Technical Baba Admin')");
        $insert->execute([$hash]);
        echo "✅ Created admin user with password '$password' successfully!\n";
    }

    echo "Hash: $hash\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
