<?php
include_once 'db_connect.php';
include_once 'functions.php';


 
if ( isset( $_POST['userName'] ) ){
$user = strip_tags_trim( $_POST['userName'] );}
 

 if ( isset( $_POST['levelLetter'] ) ){
$level = strip_tags_trim( $_POST['levelLetter'] );}

// var_dump($_POST);
//  $level='D';
//  $user='gregorio';
 
 
 
         
 $user_words_level=$user.'_words_level';
// echo '<br>'.$user_words_level.'<br>';
 $words_user='words_'.$user;
// echo '<br>'.$words_user.'<br>';
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
where the_words.`level`='$level' AND the_user.last_asked > '0' AND the_user.words_number < '3'";
$result1 = $conn->query($sql1);

 
$sql2 = "select COUNT(level) as total from $user_words_level";
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
//$sql = "select points from pointslevel
//WHERE user_id='$id'";
//  $result = $conn->query($sql);
//if ($result->num_rows > 0) {
//    $row=$result->fetch_assoc();
//    
//       $newPoints=$row["points"]+$points;
////       echo $row["points"];
////       echo '</br>'.$newPoints;
//       
//       
//       $sql1 = "UPDATE pointslevel
//SET points = '$newPoints'
//WHERE user_id='$id'";
//
//if ($conn->query($sql1) === TRUE) {
//  echo $newPoints;
//} else {
//    echo "Error updating record: " . $conn->error;
//     echo $sql1;
//}
//
//       
//    
//    
//} else {
//    echo $sql;
//    echo "Error updating record: " . $conn->error;
//}







mysqli_close($conn);  