<?php
include_once 'db_connect.php';
include_once 'functions.php';

//  sql1 try words with 4 or 3  very bad even from today
//  sql2 try words with 2 not from today
//  $sql3 try words with 1 not from today
//  $sql4 try words with 1 never asked
//  $sql5 try words with 0 that were correct 

if (isset($_POST['userId'])) {
    $userId = trim(strip_tags($_POST['userId']));
}

if (isset($_POST['level'])) {
    $level = trim(strip_tags($_POST['level']));
}
// $userId = 6;
// $level = 'A';

  if ($db === null) {
        throw new Exception("Database connection failed");
    }

$levels = doLevels($level);

// ! add missing words to user list 
$sql6 = "INSERT INTO words_users (user_id, words_id, words_number, last_asked)
SELECT :userId, w.id, 1, 0
FROM words w
LEFT JOIN words_users wu
ON wu.user_id = :userId AND wu.words_id = w.id
WHERE $levels And
wu.words_id IS NULL";

 try {
// Prepare the statement
            $stmt = $db->prepare($sql6);
            // Bind the user ID
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            // Execute the statement
            $stmt->execute();
                           
                // echo '<pre>';
                // print_r($dataAll);
                // echo '</pre>';
                } catch (PDOException $e) {
                    // Handle any dsds errors
                    echo "Error executing query: " . $e->getMessage();
                }


$dataAll = [];

// Assuming doLevels() function sanitizes and returns a safe SQL condition

 
// Get current date formatted for SQL
$timeForDb = strtotime('-1 day'); // Unix timestamp for 24 hours ago

// Prepare the SQL query
// ! try words with 4 or 3  very bad even from today
$sql1 = "SELECT w.word, w.folder, w.id, w.`level`, 
wu.words_number, wu.last_asked 
FROM words as w
JOIN words_users AS wu 
ON w.id = wu.words_id 
WHERE $levels AND wu.words_number IN ('3', '4') AND wu.user_id = :userId
ORDER BY RAND() 
LIMIT 15";
// echo '$sql1 :'. $sql1.'</br></br>';
try {
    // Prepare the statement
    $stmt = $db->prepare($sql1);
    // Bind the user ID
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    // Execute the statement
    $stmt->execute();
    // Fetch results
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataSingle = [
            'word' => $row['word'],
            'folder' => $row['folder'],
            'words_number' => $row['words_number'],
            'id' => $row['id']
        ];
        array_push($dataAll, $dataSingle);
    }


} catch (PDOException $e) {
    // Handle any errors
    echo "Error executing query: " . $e->getMessage();
}

// Count the number of rows fetched
$numberofRows = $stmt->rowCount();
$missingRows = 15 - $numberofRows;



// ! try words with 2 not from today
       if($missingRows>0){
// sql2 try words with 2 not from today
        $sql2 = "SELECT w.word, w.folder, w.id, w.`level`, 
wu.words_number, wu.last_asked 
FROM words as w
JOIN words_users AS wu 
ON w.id = wu.words_id 
where $levels AND wu.words_number IN ('2') AND wu.last_asked <$timeForDb 
AND wu.user_id = :userId 
ORDER BY RAND() 
LIMIT $missingRows";
// echo 'sql2: '.$sql2.'</br></br>';
            
              try { 
                // Prepare the statement
                $stmt = $db->prepare($sql2);
                // Bind the user ID
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            
                // Execute the statement
                $stmt->execute();
            
                // Fetch results
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $dataSingle = [
                        'word' => $row['word'],
                        'folder' => $row['folder'],
                        'words_number' => $row['words_number'],
                        'id' => $row['id']
                    ];
                    array_push($dataAll, $dataSingle);
    // Output the result for debugging

}
// echo '<pre>';
// print_r($dataAll);
// echo '</pre>';
} catch (PDOException $e) {
    // Handle any errors
    echo "Error executing query: " . $e->getMessage();
}
}


             
$missingRows=15-count($dataAll);

 

if($missingRows>0){
    ////         //dont have enough make new selectable_words     
    //! $sql3 try words with 1 not from today but already asked
    $sql3 = "SELECT w.word, w.folder, w.id, w.`level`, 
    wu.words_number, wu.last_asked 
    FROM words as w
    JOIN words_users AS wu 
    ON w.id = wu.words_id 
    where $levels AND wu.words_number='1' AND wu.last_asked <$timeForDb AND wu.last_asked >0    
    AND wu.user_id = :userId 
    ORDER BY RAND() 
    LIMIT $missingRows";
    //   echo 'sql3: '.$sql3.'</br></br>';           
                  try {
                    // Prepare the statement
                    $stmt = $db->prepare($sql3);
                    // Bind the user ID
                    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                
                    // Execute the statement
                    $stmt->execute();
                
                    // Fetch results
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $dataSingle = [
                            'word' => $row['word'],
                            'folder' => $row['folder'],
                            'words_number' => $row['words_number'],
                            'id' => $row['id']
                        ];
                        array_push($dataAll, $dataSingle);
        // Output the result for debugging
    
    }
    // echo '<pre>';
    // print_r($dataAll);
    // echo '</pre>';
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error executing query: " . $e->getMessage();
    }
    }
    $missingRows=15-count($dataAll);

 
// echo "Words List: $wordslist<br>"; // Debugging output
// ! $sql4 try words never asked
    if($missingRows>0){
        ////         //dont have enough make new selectable_words     
                $sql4 = "SELECT w.word, w.folder, w.id, w.`level`, 
        wu.words_number, wu.last_asked 
        FROM words as w
        JOIN words_users AS wu 
        ON w.id = wu.words_id 
        where $levels AND  wu.last_asked = 0
        AND wu.user_id = :userId
        ORDER BY RAND() 
        LIMIT $missingRows";
            // echo 'sql4: '.$sql4.'</br></br>';          
                      try {
                        // Prepare the statement
                        $stmt = $db->prepare($sql4);
                        // Bind the user ID
                        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                    
                        // Execute the statement
                        $stmt->execute();
                    
                        // Fetch results
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $dataSingle = [
                                'word' => $row['word'],
                                'folder' => $row['folder'],
                                'words_number' => $row['words_number'],
                                'id' => $row['id']
                            ];
                            array_push($dataAll, $dataSingle);
            // Output the result for debugging
        
        }
        // echo '<pre>';
        // print_r($dataAll);
        // echo '</pre>';
        } catch (PDOException $e) {
            // Handle any errors
            echo "Error executing query: " . $e->getMessage();
        }
        }
        $missingRows=15-count($dataAll);
        
//! try words with 0 that were correct

            if($missingRows>0){
                ////         //dont have enough make new selectable_words     
                $sql5 = "SELECT w.word, w.folder, w.id, w.`level`, 
                wu.words_number, wu.last_asked 
                FROM words as w
                JOIN words_users AS wu 
                ON w.id = wu.words_id 
                where $levels AND wu.words_number='0'
                AND wu.user_id = :userId
                ORDER BY RAND() 
                LIMIT $missingRows";




                    // echo 'sql5: '.$sql5.'</br></br>';                 
                              try {
                                // Prepare the statement
                                $stmt = $db->prepare($sql5);
                                // Bind the user ID
                                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                            
                                // Execute the statement
                                $stmt->execute();
                            
                                // Fetch results
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $dataSingle = [
                                        'word' => $row['word'],
                                        'folder' => $row['folder'],
                                        'words_number' => $row['words_number'],
                                        'id' => $row['id']
                                    ];
                                    array_push($dataAll, $dataSingle);
                    // Output the result for debugging
                
                }
                // echo '<pre>';
                // print_r($dataAll);
                // echo '</pre>';
                } catch (PDOException $e) {
                    // Handle any dsds errors
                    echo "Error executing query: " . $e->getMessage();
                }
                }


               



// print($dataAll);
 echo json_encode($dataAll); 

$db = null;
?>
