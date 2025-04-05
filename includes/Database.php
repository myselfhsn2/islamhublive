<?php
/**
 * Database Class
 * 
 * Singleton pattern implementation for database connection
 */
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        // Use the existing config.php file
        require_once 'config.php';
        
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASS;
        $database = DB_NAME;
        
        // Try to use mysqli if available, otherwise fall back to PDO
        if (class_exists('mysqli')) {
            $this->connection = new mysqli($host, $username, $password, $database);
            
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset('utf8mb4');
        } else {
            // Fallback to PDO
            try {
                $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                $this->connection = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        
        // Check if tables exist
        $this->checkTables();
    }
    
    // Check if tables exist and create them if they don't
    private function checkTables() {
        $result = $this->query("SHOW TABLES");
        $tables = [];
        
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
        
        // If no tables exist, create them
        if (empty($tables)) {
            $this->importSchemaFromFile(__DIR__ . '/../database/schema.sql');
        }
    }
    
    // Import schema from SQL file
    private function importSchemaFromFile($filepath) {
        if (file_exists($filepath)) {
            $sql = file_get_contents($filepath);
            
            // Split the file into separate SQL statements
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            // Execute each statement
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    // Skip DELIMITER statements as they're not needed in PHP
                    if (strpos($statement, 'DELIMITER') !== 0) {
                        $this->connection->query($statement);
                    }
                }
            }
        } else {
            die("Schema file not found: " . $filepath);
        }
    }
    
    // Get the singleton instance
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    // Get the database connection
    public function getConnection() {
        return $this->connection;
    }
    
    // Execute a query
    public function query($sql, $params = []) {
        if ($this->connection instanceof mysqli) {
            if (empty($params)) {
                $result = $this->connection->query($sql);
                if (!$result) {
                    die("Query failed: " . $this->connection->error);
                }
                return $result;
            } else {
                $stmt = $this->connection->prepare($sql);
                if (!$stmt) {
                    die("Prepare failed: " . $this->connection->error);
                }
                
                $types = '';
                $bindParams = [];
                $bindParams[] = &$types;
                
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i';
                    } elseif (is_float($param)) {
                        $types .= 'd';
                    } elseif (is_string($param)) {
                        $types .= 's';
                    } else {
                        $types .= 'b';
                    }
                    $bindParams[] = &$params[array_search($param, $params)];
                }
                
                call_user_func_array([$stmt, 'bind_param'], $bindParams);
                
                $stmt->execute();
                return $stmt;
            }
        } else {
            // PDO connection
            try {
                $stmt = $this->connection->prepare($sql);
                $stmt->execute($params);
                return $stmt;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }
    }
    
    public function fetchAll($result) {
        if ($result instanceof mysqli_result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // PDO statement
            return $result->fetchAll();
        }
    }
    
    public function fetch($result) {
        if ($result instanceof mysqli_result) {
            return $result->fetch_assoc();
        } elseif ($result instanceof mysqli_stmt) {
            $result = $result->get_result();
            return $result->fetch_assoc();
        } else {
            // PDO statement
            return $result->fetch();
        }
    }
    
    // Get the last inserted ID
    public function lastInsertId() {
        if ($this->connection instanceof mysqli) {
            return $this->connection->insert_id;
        } else {
            // PDO connection
            return $this->connection->lastInsertId();
        }
    }
    
    // Get the number of affected rows
    public function affectedRows() {
        if ($this->connection instanceof mysqli) {
            return $this->connection->affected_rows;
        } else {
            // PDO connection
            return $this->connection->rowCount();
        }
    }
    
    // Escape a string
    public function escape($string) {
        if ($this->connection instanceof mysqli) {
            return $this->connection->real_escape_string($string);
        } else {
            // PDO connection
            return $this->connection->quote($string);
        }
    }
    
    // Call a stored procedure
    public function callProcedure($procedure, $params = []) {
        $paramStr = implode(',', array_fill(0, count($params), '?'));
        $sql = "CALL $procedure($paramStr)";
        return $this->query($sql, $params);
    }
} 