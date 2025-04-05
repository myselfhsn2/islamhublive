<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check for mysqli extension
echo "<h2>PHP Configuration</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>mysqli extension: " . (extension_loaded('mysqli') ? 'Loaded ✅' : 'Not loaded ❌') . "</p>";
echo "<p>PDO extension: " . (extension_loaded('pdo') ? 'Loaded ✅' : 'Not loaded ❌') . "</p>";
echo "<p>PDO MySQL driver: " . (extension_loaded('pdo_mysql') ? 'Loaded ✅' : 'Not loaded ❌') . "</p>";

// Include database config
require_once __DIR__ . '/includes/config.php';

echo "<h2>Database Configuration</h2>";
echo "<p>Host: " . DB_HOST . "</p>";
echo "<p>User: " . DB_USER . "</p>";
echo "<p>Database: " . DB_NAME . "</p>";

// Test direct mysqli connection
echo "<h2>Testing Direct mysqli Connection</h2>";
try {
    if (extension_loaded('mysqli')) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($mysqli->connect_error) {
            echo "<p style='color: red;'>mysqli connection failed: " . $mysqli->connect_error . "</p>";
        } else {
            echo "<p style='color: green;'>mysqli connection successful ✅</p>";
            
            // Try a simple query
            $result = $mysqli->query("SELECT 1");
            if ($result) {
                echo "<p style='color: green;'>mysqli query successful ✅</p>";
                $result->close();
            } else {
                echo "<p style='color: red;'>mysqli query failed: " . $mysqli->error . "</p>";
            }
            
            $mysqli->close();
        }
    } else {
        echo "<p style='color: red;'>mysqli extension not available ❌</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>mysqli error: " . $e->getMessage() . "</p>";
}

// Test direct PDO connection
echo "<h2>Testing Direct PDO Connection</h2>";
try {
    if (extension_loaded('pdo') && extension_loaded('pdo_mysql')) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        echo "<p style='color: green;'>PDO connection successful ✅</p>";
        
        // Try a simple query
        $stmt = $pdo->query("SELECT 1");
        if ($stmt) {
            echo "<p style='color: green;'>PDO query successful ✅</p>";
        } else {
            echo "<p style='color: red;'>PDO query failed</p>";
        }
    } else {
        echo "<p style='color: red;'>PDO or PDO_MySQL extension not available ❌</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>PDO error: " . $e->getMessage() . "</p>";
}

// Test Database class
echo "<h2>Testing Database Class</h2>";
try {
    require_once __DIR__ . '/includes/Database.php';
    
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    if ($conn) {
        echo "<p style='color: green;'>Database class connection successful ✅</p>";
        
        // Check if users table exists
        $result = $db->query("SHOW TABLES LIKE 'users'");
        if ($db->fetch($result)) {
            echo "<p style='color: green;'>'users' table exists ✅</p>";
            
            // Count users
            $result = $db->query("SELECT COUNT(*) as count FROM users");
            $data = $db->fetch($result);
            echo "<p>Number of users: " . $data['count'] . "</p>";
        } else {
            echo "<p style='color: red;'>'users' table does not exist ❌</p>";
        }
    } else {
        echo "<p style='color: red;'>Database class connection failed ❌</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Database class error: " . $e->getMessage() . "</p>";
}
?> 