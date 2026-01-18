<?php
include_once 'db_connect.php';
include_once 'functions.php';


 
if ( isset( $_POST['userId'] ) ){
$user = strip_tags_trim( $_POST['userId'] );}
 

 if ( isset( $_POST['levelLetter'] ) ){
$level = strip_tags_trim( $_POST['levelLetter'] );}

// var_dump($_POST);
//  $level='D';
//  $user='gregorio';
 

 //make list of all words in level
    //if level >85 good move to next one
    //good means has been asked last asked> 0 and word number < 2 
  
 $sql = "select COUNT(level)as total from words where level='$level'";
 echo '<br>$sql: '.$sql.'<br>';
 $result = $conn->query($sql);
 
 $row = $result->fetch_assoc();
  
 $totalAll=$row['total'];
  echo '<br>total: '. ($row['total'])  ;
 
 $sql1 = "create or REPLACE View $user_words_level as Select the_words.`level`,    
the_user.words_id, the_user.words_number, the_user.last_asked 
from words as the_words 
join $words_user as the_user 
on the_words.id = the_user.words_id 
where the_words.`level`='$level' 
AND the_user.last_asked > '0' AND the_user.words_number < '3'";
$result1 = $conn->query($sql1);

 
$sql2 = "select COUNT(level) as total, w.`level`,    
wu.words_id, wu.words_number, wu.last_asked 
from words as w 
join words_users as wu 
on w.id = wu.words_id 
where w.`level`='$level' 
AND wu.last_asked > '0' AND wu.words_number < '3'";
echo '<br>$sql2: '.$sql2.'<br>';
 $result2 = $conn->query($sql2);
 if ($result->num_rows > 0) {
 $row2 = $result2->fetch_assoc();
// print_r($row2);
 $totalGood=$row2['total'];
  echo '<br>total good: '.($row2['total'])  ;
  }else{
//    echo $sql2;
 }
 echo '</br>';
 //calculate % from words
$reussite=calculatePercent($totalAll, $totalGood);
 if($reussite>90){echo 'Félicitations: tu passes au niveau suivant!'.$totalAll.' '.$totalGood.' '.$reussite;}else{
     echo 'Termine ce niveau pour passer au suivant... $totalAll:'.$totalAll.' $totalGood:'.$totalGood.' $reussite:'.$reussite;
//             $totalAll.' '.$totalGood.' '.$reussite;
 }







mysqli_close($conn);  