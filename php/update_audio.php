<?php
include_once 'db_connect.php';
include_once 'functions.php';
 if ( isset( $_POST['audio'] ) ){
$audio = strip_tags_trim( $_POST['audio'] );}

if ( isset( $_POST['id'] ) ){
$id = strip_tags_trim( $_POST['id'] );}

       
$sql1 = "UPDATE pointslevel SET audio='$audio' WHERE user_id='$id'";

if ($conn->query($sql1) === TRUE) {
  echo 'audio updated';
} else {
    echo "Error updating record: " . $conn->error;
     echo $sql1;
}

       
    
    







mysqli_close($conn);  