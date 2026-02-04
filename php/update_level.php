<?php
include_once 'db_connect.php';  // Ensure this file sets up the $db PDO connection
include_once 'functions.php';

// Example values, replace these with actual POST data if needed
if ( isset( $_POST['userId'] ) ){
   $userId = strip_tags_trim( $_POST['userId'] );}
    
   
    if ( isset( $_POST['levelLetter'] ) ){
   $level = strip_tags_trim( $_POST['levelLetter'] );}

try {
    // Prepare the SQL statement
    $sql = "SELECT COUNT(level) AS total FROM words WHERE level = :level";
    if ($db === null) {
        throw new Exception("Database connection failed");
    }
    $stmt = $db->prepare($sql);

    // Bind the level parameter
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalAll = $row['total'];

   //  // Output the results for debugging
   //   echo '<br>$sql: ' . htmlspecialchars($sql) . '<br>';
   //   echo '<br>Total: ' . htmlspecialchars($totalAll) . '<br>';

} catch (PDOException $e) {
    // Handle any errors
    echo "Error: " . htmlspecialchars($e->getMessage());
}


try {
   // Prepare the SQL statement
   $sql2 = "SELECT COUNT(level) AS totalUser
            FROM words AS w
            JOIN words_users AS wu ON w.id = wu.words_id
            WHERE w.`level` = :level
              AND wu.last_asked > '0'
              AND wu.words_number < '3'
              AND wu.user_id=$userId";

   // Debugging output
   //  echo '<br>$sql2: ' . htmlspecialchars($sql2) . '<br>';

   // Prepare the statement
    if ($db === null) {
        throw new Exception("Database connection failed");
    }
   $stmt = $db->prepare($sql2);

   // Bind the level parameter
   $stmt->bindParam(':level', $level, PDO::PARAM_STR);

   // Execute the statement
   $stmt->execute();

   // Fetch the result
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   $totalUser = $row['totalUser'];

   // Output the result for debugging
   //   echo '<br>Total User: ' . htmlspecialchars($totalUser) . '<br>';

} catch (PDOException $e) {
   // Handle any errors
   echo "Error: " . htmlspecialchars($e->getMessage());
}


// Close the PDO connection (optional, PDO connection closes automatically at script end)

$reussite=calculatePercent($totalAll, $totalUser);
if($reussite>90){
   echo 'Ce niveau a '.$totalAll.' mots. tu en as: '.$totalUser.' corrects. -> '.$reussite.'% de réussite. </br>Félicitations: tu passes au niveau suivant! ';
} else {
   echo 'Termine ce niveau pour passer au suivant... Ce niveau a '.$totalAll.' mots. tu en as: '.$totalUser.' corrects. -> '.$reussite.'% de réussite.';
}

$db = null;
?>
