<?php
require("db_connect.php");
// print_r($_SESSION);
$dataAll=[]; 
//echo'<br>';
//$id=$_SESSION['user']['id'];
$id= $_SESSION['user']['id'];
//echo '$id: '. $id.'<br>';
$sql = "select level,audio from pointslevel WHERE user_id='$id'";
//echo '$sql'.$sql.'<br>';
//$result = $db->query($sql);
$result = $db->query($sql);
//if ($result->num_rows > 0) {
//    $row=$result->fetch_assoc();
while ($row = $result->fetch()) {
    
       $level=$row["level"];
       $audio=$row["audio"];
//      echo $row["points"].'<br>';
//      echo '</br>'.$newPoints.'<br>';
            
 
$dataAll['level']=$level;
$dataAll['username']=$_SESSION['user']['username'];
$dataAll['id']=$_SESSION['user']['id'];
$dataAll['audio']=$audio;

//echo '$level'+ $level;
//echo '$dataAll[username]'+ $dataAll['username'];
//echo '$dataAll[id]'+ $dataAll['id'];
}
echo json_encode($dataAll);    



       
    
    
