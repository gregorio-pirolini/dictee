<?php
include_once 'db_connect.php';
include_once 'functions.php';

if ( isset( $_POST['val'] ) ){
$val = strip_tags_trim( $_POST['val'] );}

if ( isset( $_POST['id'] ) ){
$id = strip_tags_trim( $_POST['id'] );}

if ( isset( $_POST['user'] ) ){
$user = strip_tags_trim( $_POST['user'] );}

$words_user='words_'.$user;

$nowtime = time();
$now = date ('Y-m-d', $nowtime);
$aNow= explode ( '-' , $now);
$timeForDb=mktime(0,0,0,$aNow[1],$aNow[2],$aNow[0]);

$sql = "UPDATE $words_user
SET words_number = '$val', 
last_asked = '$timeForDb'     
WHERE words_id=$id;";
  
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
mysqli_close($conn);  