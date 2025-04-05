<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Output basic PHP info
echo "<h1>PHP Environment</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Loaded Extensions: " . implode(', ', get_loaded_extensions()) . "</p>";

// Check session
echo "<h1>Session Status</h1>";
echo "<p>Session Status: " . session_status() . " (2=active)</p>";
echo "<p>Session ID: " . session_id() . "</p>";

// Print session data
echo "<h2>Current Session Data:</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Add something to session
$_SESSION['test'] = 'This is a test at ' . date('Y-m-d H:i:s');
echo "<p>Added test value to session</p>";

// Check if we can connect to database
echo "<h1>Database Connection Test</h1>";
try {
    $mysqli = new mysqli('localhost', 'root', '', 'islamhub');
    
    if ($mysqli->connect_error) {
        echo "<p style='color:red'>Connection failed: " . $mysqli->connect_error . "</p>";
    } else {
        echo "<p style='color:green'>Connected to database successfully!</p>";
        
        // Check tables
        $result = $mysqli->query("SHOW TABLES");
        if ($result) {
            echo "<h2>Tables:</h2>";
            echo "<ul>";
            while ($row = $result->fetch_row()) {
                echo "<li>" . $row[0] . "</li>";
            }
            echo "</ul>";
        }
        
        // Check users table
        $result = $mysqli->query("SELECT id, username, email, full_name FROM users LIMIT 5");
        if ($result) {
            echo "<h2>Users:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['full_name'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        // Check if we can create a test user
        echo "<h1>Test User Creation</h1>";
        try {
            if ($mysqli) {
                // Check if test user exists
                $checkStmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
                $testUsername = 'testuser';
                $checkStmt->bind_param("s", $testUsername);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();
                
                if ($checkResult->num_rows > 0) {
                    echo "<p>Test user already exists.</p>";
                } else {
                    // Create test user with known password
                    $createStmt = $mysqli->prepare("INSERT INTO users (username, email, password, full_name, is_active) VALUES (?, ?, ?, ?, ?)");
                    $email = 'test@example.com';
                    $password = password_hash('Password123', PASSWORD_DEFAULT);
                    $fullName = 'Test User';
                    $isActive = 1;
                    
                    $createStmt->bind_param("ssssi", $testUsername, $email, $password, $fullName, $isActive);
                    
                    if ($createStmt->execute()) {
                        echo "<p style='color:green'>Test user created successfully!</p>";
                        echo "<div style='background-color:#eee; padding:10px; margin:10px 0;'>";
                        echo "<p><strong>Login with:</strong></p>";
                        echo "<p>Username: testuser</p>";
                        echo "<p>Password: Password123</p>";
                        echo "</div>";
                    } else {
                        echo "<p style='color:red'>Error creating test user: " . $createStmt->error . "</p>";
                    }
                }
            }
        } catch (Exception $e) {
            echo "<p style='color:red'>Exception creating user: " . $e->getMessage() . "</p>";
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Exception: " . $e->getMessage() . "</p>";
}

// Debug other potential issues
echo "<h1>Server Information</h1>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
?> 