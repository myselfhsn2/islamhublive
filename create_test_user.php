<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once __DIR__ . '/includes/Database.php';

// Connect to database
$db = Database::getInstance();

// Check if test user already exists
$result = $db->query("SELECT * FROM users WHERE username = 'testuser' OR email = 'test@islamhub.com'");
$user = $db->fetch($result);

if ($user) {
    echo "<p>Test user already exists!</p>";
    echo "<p>Username: testuser</p>";
    echo "<p>Password: Password123</p>";
    echo "<p><a href='direct_login.php'>Go to login page</a></p>";
} else {
    // Create test user
    $username = 'testuser';
    $email = 'test@islamhub.com';
    $password = password_hash('Password123', PASSWORD_DEFAULT);
    $full_name = 'Test User';
    
    $query = "INSERT INTO users (username, email, password, full_name, is_active, created_at) 
              VALUES (?, ?, ?, ?, TRUE, NOW())";
    
    $stmt = $db->query($query, [$username, $email, $password, $full_name]);
    
    if ($db->lastInsertId() > 0) {
        echo "<p>Test user created successfully!</p>";
        echo "<p>Username: testuser</p>";
        echo "<p>Password: Password123</p>";
        echo "<p><a href='direct_login.php'>Go to login page</a></p>";
    } else {
        echo "<p>Error creating test user. Please check your database setup.</p>";
    }
}
?> 