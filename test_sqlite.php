<?php
// Test SQLite connection
echo "Testing SQLite connection...\n";

// Check if PDO SQLite is available
if (!extension_loaded('pdo_sqlite')) {
    echo "ERROR: PDO SQLite extension is not loaded!\n";
    exit(1);
}

echo "✓ PDO SQLite extension is loaded\n";

// Test database connection
try {
    $dbPath = __DIR__ . '/database/civic_sense.db';
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ SQLite database connection successful!\n";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "✓ Test query successful: " . $result['test'] . "\n";
    
    // Check if tables exist
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll();
    echo "✓ Tables found: " . count($tables) . "\n";
    foreach ($tables as $table) {
        echo "  - " . $table['name'] . "\n";
    }
    
} catch (PDOException $e) {
    echo "ERROR: Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nAll tests passed! SQLite is working correctly.\n";
?>
