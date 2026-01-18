<?php
if (isset($_POST['username'])) {
 
    // Ensure $user is properly sanitized
  $user = strip_tags(trim($_POST['username']));
  
    
    // Include database connection
    include_once 'php/db_connect.php';

    // Check if connection is successful (for PDO, you usually handle connection errors with exceptions)
    if (!$db) {
        die("Database connection failed.");
    }

    // Prepare the statement using PDO
    $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
    if (!$stmt) {
        die("Prepare failed.");
    }

    // Bind the parameter and check if it works
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);

    // Execute the statement and check for errors
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->errorInfo()[2]);
    }

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = $row['id'];

    // Check if user was found
    if (!$userId) {
        die("User not found.");
    }

    // Insert into `pointslevel`
    $stmt = $db->prepare("INSERT INTO pointslevel (user_id, level, points, audio) VALUES (:user_id, 'A', 0, 44)");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        die("Error inserting into pointslevel: " . $stmt->errorInfo()[2]);
    }

    // Prepare to fill the `words_users` table
    $dataAll = [];
    $sql0 = "SELECT id FROM words ORDER BY id ASC";
    $stmt0 = $db->query($sql0);
    while ($row = $stmt0->fetch(PDO::FETCH_ASSOC)) {
        $dataAll[] = $row['id'];
    }

    // Batch insert into `words_users`
    $stmt = $db->prepare("INSERT INTO words_users (words_id, words_number, last_asked, user_id) VALUES (:words_id, '1', '0', :user_id)");
    foreach ($dataAll as $data) {
        $stmt->bindParam(':words_id', $data, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            die("Error inserting into words_users: " . $stmt->errorInfo()[2]);
        }
    }

    echo "User and words inserted successfully.";
}
?>