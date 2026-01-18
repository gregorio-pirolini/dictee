<?php
include_once 'db_connect.php'; // Ensure this file initializes the PDO connection in $db
include_once 'functions.php';

// Check and sanitize input
if (isset($_POST['audio'])) {
    $audio = strip_tags(trim($_POST['audio']));
}

if (isset($_POST['id'])) {
    $id = strip_tags(trim($_POST['id']));
}

// Prepare the SQL query using placeholders
$sql1 = "UPDATE pointslevel SET audio = :audio WHERE user_id = :id";

try {
    // Prepare the statement
    $stmt = $db->prepare($sql1);

    // Bind parameters to the placeholders
    $stmt->bindParam(':audio', $audio, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        echo 'Audio updated';
    } else {
        echo 'Error updating record';
    }
} catch (PDOException $e) {
    // Handle any errors
    echo 'Error updating record: ' . $e->getMessage();
}
