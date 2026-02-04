<?php
include_once 'db_connect.php';
include_once 'functions.php';

//try words with 4 very bad even from today
//try words with 3 not from today
//try words with 2 not from today
//try words with 1 never asked
//try words with 0 that were correct

// Hardcoded values for testing, these would typically come from a POST request
 
$userId = 25;
 

$level = 'C';


$dataAll = [];

// Assuming doLevels() function sanitizes and returns a safe SQL condition
$levels = doLevels($level);
if ($db === null) {
        throw new Exception("Database connection failed");
     }
if (!$levels || $levels === null || $level === 'null') {
    $levels = "1=1";
    error_log("Fallback triggered: level was '$level' → using no level filter");
}

// Get current date formatted for SQL
$now = date('Y-m-d');
$timeForDb = strtotime($now); // Unix timestamp for today at midnight

// Prepare the SQL query
// ! try words with 4 very bad even from today
$sql1 = "SELECT w.word, w.folder, w.id, w.`level`, 
wu.words_number, wu.last_asked 
FROM words as w
JOIN words_users AS wu 
ON w.id = wu.words_id 
WHERE $levels AND wu.words_number IN ('3', '4') AND wu.user_id = :userId
ORDER BY RAND() 
LIMIT 15";
// echo $sql1;
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

    // Output the result for debugging
    // echo '<pre>';
    // print_r($dataAll);
    // echo '</pre>';

} catch (PDOException $e) {
    // Handle any errors
    echo "Error executing query: " . $e->getMessage();
}

// Count the number of rows fetched
$numberofRows = $stmt->rowCount();
$missingRows = 15 - $numberofRows;

// Ensure wordslist function works correctly
$wordslist = wordslist($dataAll);
// echo "Words List: $wordslist<br>"; // Debugging output
// ! try words with 3 not from today
       if($missingRows>0){
////         //dont have enough make new selectable_words     
        $sql2 = "SELECT w.word, w.folder, w.id, w.`level`, 
wu.words_number, wu.last_asked 
FROM words as w
JOIN words_users AS wu 
ON w.id = wu.words_id 
where $levels AND wu.words_number='2' AND wu.last_asked <$timeForDb 
AND wu.user_id = :userId $wordslist
ORDER BY RAND() 
LIMIT $missingRows";
// echo $sql2;
            
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
// Ensure wordslist function works correctly
$wordslist = wordslist($dataAll);
// echo "Words List: $wordslist<br>"; // Debugging output
if($missingRows>0){
    ////         //dont have enough make new selectable_words     
    // ! try words with 1 not from today
            $sql3 = "SELECT w.word, w.folder, w.id, w.`level`, 
    wu.words_number, wu.last_asked 
    FROM words as w
    JOIN words_users AS wu 
    ON w.id = wu.words_id 
    where $levels AND wu.words_number='1' AND wu.last_asked <$timeForDb 
    AND wu.user_id = :userId $wordslist
    ORDER BY RAND() 
    LIMIT $missingRows";
       // echo $sql3;           
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
// Ensure wordslist function works correctly
$wordslist = wordslist($dataAll);
// echo "Words List: $wordslist<br>"; // Debugging output
// ! try words with 0 that were correct
    if($missingRows>0){
        ////         //dont have enough make new selectable_words     
                $sql4 = "SELECT w.word, w.folder, w.id, w.`level`, 
        wu.words_number, wu.last_asked 
        FROM words as w
        JOIN words_users AS wu 
        ON w.id = wu.words_id 
        where $levels AND wu.words_number='1' AND wu.last_asked <=$timeForDb 
        AND wu.user_id = :userId $wordslist
        ORDER BY RAND() 
        LIMIT $missingRows";
            // echo $sql4;          
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
        // Ensure wordslist function works correctly
        $wordslist = wordslist($dataAll);
        // echo "Words List: $wordslist<br>"; // Debugging output
        // ! try words with 0 that were correct
            if($missingRows>0){
                ////         //dont have enough make new selectable_words     
                        $sql5 = "SELECT w.word, w.folder, w.id, w.`level`, 
                wu.words_number, wu.last_asked 
                FROM words as w
                JOIN words_users AS wu 
                ON w.id = wu.words_id 
                where $levels AND wu.words_number='0'
                AND wu.user_id = :userId $wordslist
                ORDER BY RAND() 
                LIMIT $missingRows";
                    // echo $sql5;          
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
echo json_encode($dataAll);      
$db = null;
?>
