<?php
// Database connection settings
// $host = "localhost";
// $username = "root";
// $password = "greg2023";
// $dbname = "dictee";



$host = "127.0.0.1";
$dbname = "dictee";
$username = "dictee_user";
$password = "MyDictee!2026";
// Uncomment these lines if using a different database configuration
// $host = "rdbms.strato.de";
// $username = "U1210398";
// $password = "dictee_magique2";
// $dbname = "DB1210398";

try {
    // Corrected variable names from $servername and $connname to $host and $dbname
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optionally, set the default fetch mode to objects for a more consistent result format
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    
    // Optionally, set the character set for the connection
    $db->exec("SET NAMES utf8mb4");
    
    // Uncomment this line if you want to confirm connection success
    // echo "Connected successfully";
    
} catch (PDOException $e) {
    // Log the error for your reference (e.g., in a log file or database)
    error_log("Connection failed: " . $e->getMessage());
    
    // Display a user-friendly error message to the end-users
    echo "Oops! Something went wrong. Please try again later.";
}
?>
