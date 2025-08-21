<?php
// Test PDO MySQL connection
echo "Testing PDO MySQL connection...\n";

// Check if PDO is available
if (!extension_loaded('pdo')) {
    echo "ERROR: PDO extension is not loaded!\n";
    exit(1);
}

echo "✓ PDO extension is loaded\n";

// Check if PDO MySQL driver is available
if (!extension_loaded('pdo_mysql')) {
    echo "ERROR: PDO MySQL driver is not loaded!\n";
    exit(1);
}

echo "✓ PDO MySQL driver is loaded\n";

// List available PDO drivers
echo "Available PDO drivers: " . implode(', ', PDO::getAvailableDrivers()) . "\n";

// Test database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=civic_sense_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Database connection successful!\n";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "✓ Test query successful: " . $result['test'] . "\n";
    
} catch (PDOException $e) {
    echo "ERROR: Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nAll tests passed! PDO MySQL is working correctly.\n";
?>
