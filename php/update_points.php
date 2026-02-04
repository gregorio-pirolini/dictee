<?php
include_once 'db_connect.php';
include_once 'functions.php';

// Initialize variables
$points = 0;
$id = 0;

// Validate and sanitize POST data
if (isset($_POST['points'])) {
    $points = strip_tags_trim($_POST['points']); // Corrected $_POST['points']
}

if (isset($_POST['id'])) {
    $id = strip_tags_trim($_POST['id']); // Corrected $_POST['id']
}

try {
    // Prepare the SQL statement to select the current points
    $sql = "SELECT points FROM pointslevel WHERE user_id = :id";
    if ($db === null) {
        throw new Exception("Database connection failed");
     }
    $stmt = $db->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Check if the user exists
    if ($stmt->rowCount() > 0) {
        // Fetch the current points
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentPoints = $row['points'];

        // Calculate the new points
        $newPoints = $currentPoints + $points;

        // Prepare the SQL statement to update the points
        $sql1 = "UPDATE pointslevel SET points = :newPoints WHERE user_id = :id";
        $stmt = $db->prepare($sql1);

        // Bind parameters
        $stmt->bindParam(':newPoints', $newPoints, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the update statement
        if ($stmt->execute()) {
            echo $newPoints;
        } else {
            echo "Error updating record";
        }

    } else {
        echo "User not found";
    }

} catch (PDOException $e) {
    // Handle any errors
    echo "Error: " . htmlspecialchars($e->getMessage());
}

// Close the PDO connection (optional, PDO connection closes automatically at script end)
$db = null;
?>
