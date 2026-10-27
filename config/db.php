<?php
/**
 * Database Connection File
 * -------------------------
 * Include this at the top of every page that needs the database:
 *   require_once 'config/db.php';        (from project root)
 *   require_once '../config/db.php';     (from a subfolder like books/)
 */

// --- Connection settings ---
$db_host = getenv('DB_HOST') ?: "localhost";
$db_user = getenv('DB_USER') ?: "root";      // default XAMPP/WAMP username
$db_pass = getenv('DB_PASS') ?: "";          // default XAMPP/WAMP password is blank
$db_name = getenv('DB_NAME') ?: "library_db"; // The "getenv" is to read configuration from environment variables for containerization.

// --- Create connection ---
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// --- Check connection ---
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Set charset (prevents encoding issues with special characters) ---
$conn->set_charset("utf8mb4");
?>