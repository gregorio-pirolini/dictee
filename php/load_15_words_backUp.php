<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
//! if ( isset( $_POST['user'] ) ){
//! $userId = strip_tags_trim( $_POST['userId']);}

//! if ( isset( $_POST['level'] ) ){
//! $level = strip_tags_trim( $_POST['level']);}

$userId = 6;
$level = 'D';
$dataAll=[];


$levels=doLevels($level);


//try words with 4 very bad even from today
//try words with 3 not from today
//try words with 2 not from today
//try words with 1 never asked
//try words with 0 that were correct
//take words
$nowtime = time();
$now = date ('Y-m-d', $nowtime);
$aNow= explode ( '-' , $now);
$timeForDb=mktime(0,0,0,$aNow[1],$aNow[2],$aNow[0]);// month -day -year

 
    
$sql1 = "SELECT w.word, w.folder, w.id, w.`level`, 
wu.words_number, wu.last_asked 
FROM words as w
JOIN word_users  AS wu 
ON w.id = wu.words_id 
WHERE $levels And (wu.words_number='3' or wu.words_number='4') and wu.user_id = $userId
ORDER BY RAND() LIMIT 15" ;   
$result = $db->query($sql1);
    if ($result->num_rows > -1) {
 
    while($row = $result->fetch_assoc()) {
    $dataSingle=[];
    $dataSingle['word']=$row["word"];
    $dataSingle['folder']=$row["folder"];
    $dataSingle['words_number']=$row["words_number"];
    $dataSingle['id']=$row["id"];
    array_push($dataAll,$dataSingle);
    }
 
 
    
   
    $numberofRows=$result->num_rows;
    $missingRows=15-$numberofRows;  
       if($missingRows>0){
////         //dont have enough make new selectable_words     
        $sql2 = "create or REPLACE  View $selectable_words  
        as Select the_words.id, the_words.word, the_words.folder, the_words.`level`, 
        the_user.words_id, the_user.words_number, the_user.last_asked 
        from words as the_words 
        join $userWords as the_user 
        on the_words.id = the_user.words_id
        where $levels And the_user.words_number='2' And last_asked <$timeForDb";      
            if ($db->query($sql2) === TRUE) {
 
                
            $sql3 = "SELECT word, folder, words_number, id "
             . "FROM $selectable_words "
             . "ORDER BY RAND() LIMIT $missingRows"; 
             $result3 = $db->query($sql3);
                  if ($result3->num_rows > -1) {
//           // output data of each row
                while($row = $result3->fetch_assoc()) {
                $dataSingle=[];
                $dataSingle['word']=$row["word"];
                $dataSingle['folder']=$row["folder"];
                $dataSingle['words_number']=$row["words_number"];
                $dataSingle['id']=$row["id"];
                 array_push($dataAll,$dataSingle);
               }
 
               
             $missingRows=15-count($dataAll);
                     if($missingRows>0){//do the ones that are not asked yet
                    $sql4 = "create or REPLACE  View $selectable_words 
                    as Select the_words.id, the_words.word, the_words.folder, the_words.`level`, 
                    the_user.words_id, the_user.words_number, the_user.last_asked 
                    from words as the_words 
                    join $userWords as the_user 
                    on the_words.id = the_user.words_id
                    where $levels And the_user.words_number='1' And last_asked <$timeForDb"; 
                     if ($db->query($sql4) === TRUE) {
                         
            
                        $sql5 = "SELECT word, folder, words_number, id "
                        . "FROM $selectable_words "
                        . "ORDER BY RAND() LIMIT $missingRows"; 
                        $result5 = $db->query($sql5);
                            if ($result5->num_rows > -1) {
                            while($row = $result5->fetch_assoc()) {
                            $dataSingle=[];
                            $dataSingle['word']=$row["word"];
                            $dataSingle['folder']=$row["folder"];
                            $dataSingle['words_number']=$row["words_number"];
                            $dataSingle['id']=$row["id"];
                            array_push($dataAll,$dataSingle); }
 
                            
                            $missingRows=15-count($dataAll);
                                 if($missingRows>0){//do the ones that are not asked yet
                                $sql6 = "CREATE or REPLACE VIEW $selectable_words
                                AS SELECT the_words.id, the_words.word, the_words.folder, the_words.`level`, 
                                the_user.words_id, the_user.words_number, the_user.last_asked 
                                FROM words AS the_words 
                                JOIN $userWords AS the_user 
                                ON the_words.id = the_user.words_id
                                WHERE $levels AND the_user.words_number='0' And last_asked <$timeForDb"; 
                                   if ($db->query($sql6) === TRUE) {
//                             //pick from 0 correct
 
                                    $sql7 = "SELECT word, folder, words_number, id "
                                    . "FROM $selectable_words "
                                    . "ORDER BY RAND() LIMIT $missingRows"; 
                                    $result7 = $db->query($sql7);
                                     if ($result7->num_rows > -1) {
                                        while($row = $result7->fetch_assoc()) {
                                        $dataSingle=[];
                                        $dataSingle['word']=$row["word"];
                                        $dataSingle['folder']=$row["folder"];
                                        $dataSingle['words_number']=$row["words_number"];
                                        $dataSingle['id']=$row["id"];
                                        array_push($dataAll,$dataSingle);
                                        }
 
                                        $missingRows=15-count($dataAll);
                                            if($missingRows>0){//do the ones that are not asked yet
                                            $sql8 = "CREATE View $selectable_words
                                            as Select the_words.id, the_words.word, the_words.folder, the_words.`level`, 
                                            the_user.words_id, the_user.words_number, the_user.last_asked 
                                            from words as the_words 
                                            join $userWords as the_user 
                                            on the_words.id = the_user.words_id
                                            where $levels And (the_user.words_number='0' or the_user.words_number='2' or the_user.words_number='1')  And last_asked =$timeForDb"; 
                                                 if ($db->query($sql8) === TRUE) {
                                                $sql9 = "SELECT word, folder, words_number, id "
                                                . "FROM $selectable_words "
                                                . "ORDER BY RAND() LIMIT $missingRows"; 
                                                $result9 = $db->query($sql9);
                                                    if ($result9->num_rows > -1) {
                                                    while($row = $result9->fetch_assoc()) {
                                                    $dataSingle=[];
                                                    $dataSingle['word']=$row["word"];
                                                    $dataSingle['folder']=$row["folder"];
                                                    $dataSingle['words_number']=$row["words_number"];
                                                    $dataSingle['id']=$row["id"];
                                                    array_push($dataAll,$dataSingle);
                                                    } 
                                                        }else{
                                                            echo '</br>';
                                                        echo 'Error: $sql9 picking from selectable view with 0  today too ' . $db->error;
                                                        echo '</br>';
                                                        echo $sql9;  
                                                        }  
                                                            
                                                     }else{
                                                         echo '</br>';
                                                        echo 'Error: $sql8 create view with 0 ANYDAY: ' . $db->error;
                                                        echo '</br>';
                                                        echo '</br>';
                                                        echo $sql8;
                                                        echo '</br>';
                                                        echo '</br>';
                                                        }
                                                 }else{
//                                                             echo 'i have 15 from o not today'; 
                                                            }
                                                }else{
                                                    echo '</br>';
                                                echo 'Error $sql7:  picking from selectable view with 0 not today: ' . $db->error;
                                                echo '</br>';
                                                echo $sql7;  
                                               }
                                            }else{
                                                echo '</br>';
                                            echo 'Error $sql6 create view with 0: ' . $db->error;
                                            echo '</br>';
                                            echo $sql6;
                                            echo '</br>';
                                            }
                                        }else{
//                                            echo 'i have 15 from 1';
                                        }
                                    }else{
                                        echo '</br>';
                                    echo 'Error $sql5 picking from selectable view with 1: ' . $db->error;
                                    echo '</br>';
                                    echo $sql5;  
                                    }     
//     
//         
                                }else{
                                    echo '</br>';
                            echo 'Error $sql4 create view with 1: ' . $db->error;
                            echo '</br>';
                            echo $sql4;
                            echo '</br>';
                            }
//     
                        }else{
//                        echo 'i have 15 from 3 2';
                   }
                }else {
                    echo '</br>';
                echo 'Error $sql1 picking from selectable view with 3 an 2: ' . $db->error;
                echo '</br>';
               echo $sql1;
                 }  
            }else{
                echo '</br>';
            echo 'Error $sql2 create view with 3 and 2: ' . $db->error;
            echo '</br>';
            echo $sql2; 
            echo '</br>';
            }
        }else{
//        echo 'i have 15 from 4';
        }   
    }else{
        echo '</br>';
    echo 'Error $sql1 picking from selectable view with 4: ' . $db->error;
    echo '</br>';
    echo $sql1;
    echo '</br>';
    }
}else{
    echo '</br>';
echo 'Error $sql create view with 4: ' . $db->error;
echo '</br>';
echo $sql;
echo '</br>';
}
// //shuffle($dataAll);
// //print '<pre>';
// //print_r($dataAll);
// //print'</pre>';
// echo json_encode($dataAll);    
// mysqli_close($db); 