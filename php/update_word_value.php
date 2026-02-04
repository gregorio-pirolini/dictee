<?php
include_once 'db_connect.php';
include_once 'functions.php';

$val = isset($_POST['val']) ? intval(trim($_POST['val'])) : 0;
$id = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0;
$userId = isset($_POST['userId']) ? intval(trim($_POST['userId'])) : 0;


$nowtime = time();
$now = date('Y-m-d', $nowtime);
$aNow = explode('-', $now);
$timeForDb = mktime(0, 0, 0, $aNow[1], $aNow[2], $aNow[0]);

try {
    if ($db === null) {
        throw new Exception("Database connection failed");
    }

    $sql = "UPDATE words_users
            SET words_number = :val, 
                last_asked = :timeForDb     
            WHERE words_id = :id
            AND user_id = :userId";

    // Prepare the statement
    $stmt = $db->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bindParam(':val', $val, PDO::PARAM_INT);
    $stmt->bindParam(':timeForDb', $timeForDb, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    echo "Record updated successfully";
} catch (PDOException $e) {
    echo "Error updating record: " . $e->getMessage();
}

// Close the connection (optional since PDO handles it automatically at the end of the script)
$db = null;
?>
