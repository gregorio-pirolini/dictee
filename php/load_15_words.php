<?php
include_once 'db_connect.php';
include_once 'functions.php';
$show='NOTshow';//help me find out what seem to be the problem

if ( isset( $_POST['user'] ) ){
$user = strip_tags_trim( $_POST['user']);}

if ( isset( $_POST['level'] ) ){
$level = strip_tags_trim( $_POST['level']);}

if($show=='show'){$user ='gregorio'; $level='D';}    

$userWords='words_'.$user;
$selectable_words='selectable_words_'.$user;
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
//echo $nowtime;
//echo '</br>';
//echo $now;
//echo '</br>';
//echo $timeForDb;
//++++++++++++++++++++++++++++++++++++++++++
//      for($i=141;$i<142;$i++){
//       $sql = "INSERT INTO words_greg (words_id,words_number,last_asked) VALUES ('$i','1','0')";
//      $conn->query($sql);   
//      }
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   
//create view with 4
$sql = "CREATE or REPLACE View $selectable_words AS 
SELECT the_words.id, the_words.word, the_words.folder, the_words.`level`,  
the_user.words_id, the_user.words_number, the_user.last_asked 
FROM words AS the_words 
JOIN $userWords AS the_user 
ON the_words.id = the_user.words_id 
WHERE $levels And (the_user.words_number='3' or the_user.words_number='4')";
// 3 or 4
 
if ($conn->query($sql) === TRUE){//pick 15 wrong
    
if($show=='show'){   
    echo '$sql:' ."Record updated successfully: $sql";}
    
$sql1 = "SELECT word, folder, words_number, id "
. "FROM $selectable_words "
. "ORDER BY RAND() LIMIT 15";    
$result = $conn->query($sql1);
    if ($result->num_rows > -1) {
//    // output data of each row
    while($row = $result->fetch_assoc()) {
    $dataSingle=[];
    $dataSingle['word']=$row["word"];
    $dataSingle['folder']=$row["folder"];
    $dataSingle['words_number']=$row["words_number"];
    $dataSingle['id']=$row["id"];
    array_push($dataAll,$dataSingle);
    }
    
    if($show=='show'){
    print '<pre>3 4';
print_r($dataAll);
print'</pre>';
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
            if ($conn->query($sql2) === TRUE) {
if($show=='show'){       
    echo '$sql2:' ."Record updated successfully: $sql2"; }  
                
            $sql3 = "SELECT word, folder, words_number, id "
             . "FROM $selectable_words "
             . "ORDER BY RAND() LIMIT $missingRows"; 
             $result3 = $conn->query($sql3);
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
if($show=='show'){                
    print '<pre> 2 but not today';
print_r($dataAll);
print'</pre>';}
               
             $missingRows=15-count($dataAll);
                     if($missingRows>0){//do the ones that are not asked yet
                    $sql4 = "create or REPLACE  View $selectable_words 
                    as Select the_words.id, the_words.word, the_words.folder, the_words.`level`, 
                    the_user.words_id, the_user.words_number, the_user.last_asked 
                    from words as the_words 
                    join $userWords as the_user 
                    on the_words.id = the_user.words_id
                    where $levels And the_user.words_number='1' And last_asked <$timeForDb"; 
                     if ($conn->query($sql4) === TRUE) {
                         
 if($show=='show'){           
     echo '$sql4:' ."Record updated successfully: $sql4";  
     }              
                        $sql5 = "SELECT word, folder, words_number, id "
                        . "FROM $selectable_words "
                        . "ORDER BY RAND() LIMIT $missingRows"; 
                        $result5 = $conn->query($sql5);
                            if ($result5->num_rows > -1) {
                            while($row = $result5->fetch_assoc()) {
                            $dataSingle=[];
                            $dataSingle['word']=$row["word"];
                            $dataSingle['folder']=$row["folder"];
                            $dataSingle['words_number']=$row["words_number"];
                            $dataSingle['id']=$row["id"];
                            array_push($dataAll,$dataSingle); }
if($show=='show'){                
    print '<pre>1 but no today';
print_r($dataAll);
print'</pre>';}
                            
                            $missingRows=15-count($dataAll);
                                 if($missingRows>0){//do the ones that are not asked yet
                                $sql6 = "CREATE or REPLACE VIEW $selectable_words
                                AS SELECT the_words.id, the_words.word, the_words.folder, the_words.`level`, 
                                the_user.words_id, the_user.words_number, the_user.last_asked 
                                FROM words AS the_words 
                                JOIN $userWords AS the_user 
                                ON the_words.id = the_user.words_id
                                WHERE $levels AND the_user.words_number='0' And last_asked <$timeForDb"; 
                                   if ($conn->query($sql6) === TRUE) {
//                             //pick from 0 correct
if($show=='show'){      
    echo '$sql6:' ."Record updated successfully: $sql6";  
    
}
                                    $sql7 = "SELECT word, folder, words_number, id "
                                    . "FROM $selectable_words "
                                    . "ORDER BY RAND() LIMIT $missingRows"; 
                                    $result7 = $conn->query($sql7);
                                     if ($result7->num_rows > -1) {
                                        while($row = $result7->fetch_assoc()) {
                                        $dataSingle=[];
                                        $dataSingle['word']=$row["word"];
                                        $dataSingle['folder']=$row["folder"];
                                        $dataSingle['words_number']=$row["words_number"];
                                        $dataSingle['id']=$row["id"];
                                        array_push($dataAll,$dataSingle);
                                        }
if($show=='show'){                                 
    print '<pre>0 but not today';
print_r($dataAll);
print'</pre>';}
                                        $missingRows=15-count($dataAll);
                                            if($missingRows>0){//do the ones that are not asked yet
                                            $sql8 = "CREATE View $selectable_words
                                            as Select the_words.id, the_words.word, the_words.folder, the_words.`level`, 
                                            the_user.words_id, the_user.words_number, the_user.last_asked 
                                            from words as the_words 
                                            join $userWords as the_user 
                                            on the_words.id = the_user.words_id
                                            where $levels And (the_user.words_number='0' or the_user.words_number='2' or the_user.words_number='1')  And last_asked =$timeForDb"; 
                                                 if ($conn->query($sql8) === TRUE) {
                                                $sql9 = "SELECT word, folder, words_number, id "
                                                . "FROM $selectable_words "
                                                . "ORDER BY RAND() LIMIT $missingRows"; 
                                                $result9 = $conn->query($sql9);
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
                                                        echo 'Error: $sql9 picking from selectable view with 0  today too ' . $conn->error;
                                                        echo '</br>';
                                                        echo $sql9;  
                                                        }  
                                                            
                                                     }else{
                                                         echo '</br>';
                                                        echo 'Error: $sql8 create view with 0 ANYDAY: ' . $conn->error;
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
                                                echo 'Error $sql7:  picking from selectable view with 0 not today: ' . $conn->error;
                                                echo '</br>';
                                                echo $sql7;  
                                               }
                                            }else{
                                                echo '</br>';
                                            echo 'Error $sql6 create view with 0: ' . $conn->error;
                                            echo '</br>';
                                            echo $sql6;
                                            echo '</br>';
                                            }
                                        }else{
//                                            echo 'i have 15 from 1';
                                        }
                                    }else{
                                        echo '</br>';
                                    echo 'Error $sql5 picking from selectable view with 1: ' . $conn->error;
                                    echo '</br>';
                                    echo $sql5;  
                                    }     
//     
//         
                                }else{
                                    echo '</br>';
                            echo 'Error $sql4 create view with 1: ' . $conn->error;
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
                echo 'Error $sql1 picking from selectable view with 3 an 2: ' . $conn->error;
                echo '</br>';
               echo $sql1;
                 }  
            }else{
                echo '</br>';
            echo 'Error $sql2 create view with 3 and 2: ' . $conn->error;
            echo '</br>';
            echo $sql2; 
            echo '</br>';
            }
        }else{
//        echo 'i have 15 from 4';
        }   
    }else{
        echo '</br>';
    echo 'Error $sql1 picking from selectable view with 4: ' . $conn->error;
    echo '</br>';
    echo $sql1;
    echo '</br>';
    }
}else{
    echo '</br>';
echo 'Error $sql create view with 4: ' . $conn->error;
echo '</br>';
echo $sql;
echo '</br>';
}
//shuffle($dataAll);
//print '<pre>';
//print_r($dataAll);
//print'</pre>';
echo json_encode($dataAll);    
mysqli_close($conn); 