<?php
include_once 'db_connect.php';
include_once 'functions.php';


if ( isset( $_POST['val'] ) ){
$level = strip_tags_trim( $_POST['$level'] );}

if ( isset( $_POST['val'] ) ){
$userid = strip_tags_trim( $_POST['userid'] );}


 
//  $level='A';
// $user='6';
 
 
 $sql = "UPDATE pointslevel SET `level` = '$level' WHERE user_id=$userid";
 


 if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}





mysqli_close($conn);  