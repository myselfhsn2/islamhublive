<?php
/**
 * User Model
 * 
 * Handles user authentication and data management
 */
class User {
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../includes/Database.php';
        $this->db = Database::getInstance();
    }
    
    /**
     * Register a new user
     *
     * @param array $userData User data including username, email, password, and full_name
     * @return bool|string True on success, error message on failure
     */
    public function register($userData) {
        // Validate data
        if (empty($userData['username']) || empty($userData['email']) || 
            empty($userData['password']) || empty($userData['full_name'])) {
            return "All fields are required";
        }
        
        // Check if username already exists
        $result = $this->db->query("SELECT id FROM users WHERE username = ?", [$userData['username']]);
        if ($this->db->fetch($result)) {
            return "Username already taken";
        }
        
        // Check if email already exists
        $result = $this->db->query("SELECT id FROM users WHERE email = ?", [$userData['email']]);
        if ($this->db->fetch($result)) {
            return "Email already registered";
        }
        
        // Hash password
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        // Prepare preferences JSON if it exists
        $preferences = isset($userData['preferences']) ? json_encode($userData['preferences']) : NULL;
        
        // Insert user
        $query = "
            INSERT INTO users (username, email, password, full_name, phone_number, preferences)
            VALUES (?, ?, ?, ?, ?, ?)
        ";
        
        $phone = isset($userData['phone_number']) ? $userData['phone_number'] : NULL;
        
        $result = $this->db->query($query, [
            $userData['username'],
            $userData['email'],
            $hashedPassword,
            $userData['full_name'],
            $phone,
            $preferences
        ]);
        
        if ($this->db->lastInsertId() > 0) {
            return true;
        } else {
            return "Registration failed. Please try again.";
        }
    }
    
    /**
     * Authenticate a user
     *
     * @param string $username Username or email
     * @param string $password Password
     * @return bool|array False on failure, user data on success
     */
    public function login($username, $password) {
        if (empty($username) || empty($password)) {
            return false;
        }
        
        // Check if input is email or username
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        // First, check if the user exists
        $sql = "SELECT id, username, email, password, full_name, preferences
                FROM users
                WHERE $field = ? AND is_active = TRUE";
        
        $result = $this->db->query($sql, [$username]);
        $user = $this->db->fetch($result);
        
        if (!$user) {
            return false;
        }
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Remove password from the array
            unset($user['password']);
            
            // Convert preferences from JSON to array
            if (!empty($user['preferences'])) {
                $user['preferences'] = json_decode($user['preferences'], true);
            } else {
                $user['preferences'] = [];
            }
            
            return $user;
        }
        
        return false;
    }
    
    /**
     * Get a user by ID
     *
     * @param int $id User ID
     * @return array|bool User data or false
     */
    public function getById($id) {
        $query = "
            SELECT id, username, email, full_name, phone_number, preferences, created_at
            FROM users
            WHERE id = ?
        ";
        
        $result = $this->db->query($query, [$id]);
        $user = $this->db->fetch($result);
        
        if ($user && !empty($user['preferences'])) {
            $user['preferences'] = json_decode($user['preferences'], true);
        }
        
        return $user;
    }
    
    /**
     * Update user preferences (including dark mode setting)
     *
     * @param int $userId User ID
     * @param array $preferences Preferences array
     * @return bool Success status
     */
    public function updatePreferences($userId, $preferences) {
        // Get current preferences
        $user = $this->getById($userId);
        if (!$user) {
            return false;
        }
        
        // Merge with existing preferences
        $currentPreferences = !empty($user['preferences']) ? $user['preferences'] : [];
        $updatedPreferences = array_merge($currentPreferences, $preferences);
        
        // Update in database
        $query = "
            UPDATE users
            SET preferences = ?
            WHERE id = ?
        ";
        
        $result = $this->db->query($query, [json_encode($updatedPreferences), $userId]);
        return $this->db->affectedRows() > 0;
    }
    
    /**
     * Update user profile
     *
     * @param int $userId User ID
     * @param array $data Data to update
     * @return bool Success status
     */
    public function updateProfile($userId, $data) {
        $allowedFields = ['full_name', 'email', 'phone_number'];
        $updates = [];
        $params = [];
        
        foreach ($data as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $updates[] = "$field = ?";
                $params[] = $value;
            }
        }
        
        if (empty($updates)) {
            return false;
        }
        
        // Add user ID to params
        $params[] = $userId;
        
        $query = "
            UPDATE users
            SET " . implode(', ', $updates) . "
            WHERE id = ?
        ";
        
        $result = $this->db->query($query, $params);
        return $this->db->affectedRows() > 0;
    }
    
    /**
     * Change user password
     *
     * @param int $userId User ID
     * @param string $currentPassword Current password
     * @param string $newPassword New password
     * @return bool|string True on success, error message on failure
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        // Verify current password
        $result = $this->db->query("SELECT password FROM users WHERE id = ?", [$userId]);
        $user = $this->db->fetch($result);
        
        if (!$user) {
            return "User not found";
        }
        
        if (!password_verify($currentPassword, $user['password'])) {
            return "Current password is incorrect";
        }
        
        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $result = $this->db->query("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, $userId]);
        
        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            return "Failed to update password";
        }
    }
    
    /**
     * Generate a password reset token
     *
     * @param string $email User email
     * @return bool|string True on success, error message on failure
     */
    public function generatePasswordResetToken($email) {
        // Make sure the password_resets table exists
        $this->createPasswordResetsTable();
        
        // Check if email exists
        $result = $this->db->query("SELECT id FROM users WHERE email = ? AND is_active = TRUE", [$email]);
        $user = $this->db->fetch($result);
        
        if (!$user) {
            return "Email not found or account is inactive";
        }
        
        $userId = $user['id'];
        
        // Delete any existing tokens for this user
        $this->db->query("DELETE FROM password_resets WHERE user_id = ?", [$userId]);
        
        // Generate a new token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store the token
        $result = $this->db->query(
            "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)",
            [$userId, $token, $expires]
        );
        
        if ($this->db->lastInsertId() > 0) {
            // In a real application, send email with the reset link
            // For now, we'll just return true for testing
            return true;
        } else {
            return "Failed to generate reset token";
        }
    }
    
    /**
     * Verify if a reset token exists and is not expired
     *
     * @param string $token Reset token
     * @return bool True if token is valid, false otherwise
     */
    public function verifyResetToken($token) {
        // Make sure the password_resets table exists
        $this->createPasswordResetsTable();
        
        $result = $this->db->query("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()", [$token]);
        return $this->db->fetch($result) ? true : false;
    }
    
    /**
     * Reset a user's password
     *
     * @param string $token Reset token
     * @param string $password New password
     * @return bool|string True on success, error message on failure
     */
    public function resetPassword($token, $password) {
        // Make sure the password_resets table exists
        $this->createPasswordResetsTable();
        
        // Verify token is valid and not expired
        $result = $this->db->query("SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW()", [$token]);
        $reset = $this->db->fetch($result);
        
        if (!$reset) {
            return "Invalid or expired token";
        }
        
        $userId = $reset['user_id'];
        
        // Update password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, $userId]);
        
        if ($this->db->affectedRows() > 0) {
            // Delete the used token
            $this->db->query("DELETE FROM password_resets WHERE token = ?", [$token]);
            
            return true;
        } else {
            return "Failed to update password";
        }
    }
    
    /**
     * Store a remember me token for a user
     *
     * @param int $userId User ID
     * @param string $token Remember token
     * @param int $expires Expiration timestamp
     * @return bool Success status
     */
    public function storeRememberToken($userId, $token, $expires) {
        // Make sure the remember_tokens table exists
        $this->createRememberTokensTable();
        
        // Delete any existing tokens for this user
        $this->db->query("DELETE FROM remember_tokens WHERE user_id = ?", [$userId]);
        
        // Store the new token
        $expiresDate = date('Y-m-d H:i:s', $expires);
        $result = $this->db->query(
            "INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)",
            [$userId, $token, $expiresDate]
        );
        
        return $this->db->lastInsertId() > 0;
    }
    
    /**
     * Get a user by remember token
     *
     * @param string $token Remember token
     * @return array|bool User data or false
     */
    public function getUserByRememberToken($token) {
        // Make sure the remember_tokens table exists
        $this->createRememberTokensTable();
        
        $query = "
            SELECT u.id, u.username, u.email, u.full_name, u.preferences
            FROM users u
            JOIN remember_tokens rt ON u.id = rt.user_id
            WHERE rt.token = ? AND rt.expires_at > NOW() AND u.is_active = TRUE
        ";
        
        $result = $this->db->query($query, [$token]);
        $user = $this->db->fetch($result);
        
        if (!$user) {
            return false;
        }
        
        // Convert preferences from JSON to array
        if (!empty($user['preferences'])) {
            $user['preferences'] = json_decode($user['preferences'], true);
        } else {
            $user['preferences'] = [];
        }
        
        return $user;
    }
    
    /**
     * Update a remember token with a new one
     *
     * @param string $oldToken Old token
     * @param string $newToken New token
     * @param int $expires New expiration timestamp
     * @return bool Success status
     */
    public function updateRememberToken($oldToken, $newToken, $expires) {
        // Make sure the remember_tokens table exists
        $this->createRememberTokensTable();
        
        $expiresDate = date('Y-m-d H:i:s', $expires);
        $result = $this->db->query(
            "UPDATE remember_tokens SET token = ?, expires_at = ? WHERE token = ?",
            [$newToken, $expiresDate, $oldToken]
        );
        
        return $this->db->affectedRows() > 0;
    }
    
    /**
     * Remove a remember token
     *
     * @param string $token Token to remove
     * @return bool Success status
     */
    public function removeRememberToken($token) {
        // Make sure the remember_tokens table exists
        $this->createRememberTokensTable();
        
        $result = $this->db->query("DELETE FROM remember_tokens WHERE token = ?", [$token]);
        return $this->db->affectedRows() > 0;
    }
    
    /**
     * Create remember_tokens table if it doesn't exist
     */
    private function createRememberTokensTable() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS remember_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                token VARCHAR(255) NOT NULL,
                expires_at DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX (token),
                INDEX (user_id)
            )
        ");
    }
    
    /**
     * Create password_resets table if it doesn't exist
     */
    private function createPasswordResetsTable() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS password_resets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                token VARCHAR(255) NOT NULL,
                expires_at DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX (token),
                INDEX (user_id)
            )
        ");
    }
} 