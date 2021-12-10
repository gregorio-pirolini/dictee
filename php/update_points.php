<?php
include_once 'db_connect.php';
include_once 'functions.php';

if ( isset( $_POST['points'] ) ){
$points = strip_tags_trim( $_POST['points'] );}
 
 if ( isset( $_POST['id'] ) ){
$id = strip_tags_trim( $_POST['id'] );}
 
 
 

$sql = "select points from pointslevel
WHERE user_id='$id'";
  $result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row=$result->fetch_assoc();
    
       $newPoints=$row["points"]+$points;
//       echo $row["points"];
//       echo '</br>'.$newPoints;
       
       
       $sql1 = "UPDATE pointslevel
SET points = '$newPoints'
WHERE user_id='$id'";

if ($conn->query($sql1) === TRUE) {
  echo $newPoints;
} else {
    echo "Error updating record: " . $conn->error;
     echo $sql1;
}

       
    
    
} else {
    echo $sql;
    echo "Error updating record: " . $conn->error;
}







mysqli_close($conn);  