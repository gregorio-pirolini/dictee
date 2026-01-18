<?php
include_once 'db_connect.php';
include_once 'functions.php';

// Initialize variables
$level = '';
$userid = 0;

// Validate and sanitize POST data
if (isset($_POST['level'])) {
    $level = strip_tags_trim($_POST['level']); // Corrected $_POST['level']
}

if (isset($_POST['userid'])) {
    $userid = strip_tags_trim($_POST['userid']); // Corrected $_POST['userid']
}

try {
    // Prepare the SQL statement
    $sql = "UPDATE pointslevel SET `level` = :level WHERE user_id = :userid";

    // Prepare the statement
    $stmt = $db->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record";
    }

} catch (PDOException $e) {
    // Handle any errors
    echo "Error updating record: " . htmlspecialchars($e->getMessage());
}

// Close the PDO connection (optional, PDO connection closes automatically at script end)
$db = null;
?>
