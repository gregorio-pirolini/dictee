<?php
if ( isset( $_POST['username'] ) ){
$user = strip_tags_trim( $_POST['username'] );}

$name='words_'.$user;
$key='FK_words_'.$user.'_words';
$sql = "CREATE TABLE `$name` (
	`words_id` INT(11) NOT NULL,
	`words_number` TINYINT(4) NOT NULL,
	`last_asked` BIGINT(20) NOT NULL,
	PRIMARY KEY (`words_id`),
	CONSTRAINT `$key` FOREIGN KEY (`words_id`) REFERENCES `words` (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;";
  $result = $conn->query($sql);
  
  // fill tabel
  $dataAll=[]; 
  $sql0 = "select id from words order by id ASC";
  $result0 = $conn->query($sql0);  
   while ($row = $result0->fetch_assoc()) {
    $id=$row["id"];
//       echo $row["points"];
//       echo '</br>'.$newPoints;
            
 array_push ($dataAll,$id);
 

}
//     print '<pre>';
//   print_r($dataAll) ;
//   print '</pre>'; 
//   echo gettype ( $dataAll[0] )
for($i=0; $i<count($dataAll); $i++){
    $data=$dataAll[$i];
  $sql1 = "INSERT INTO $name (words_id, words_number, last_asked)
VALUES ('$data', '1', '0');";  
    $result1 = $conn->query($sql1);  
}

//find id
 $sql2="select id from users where username='$user'";
 $result2 = $conn->query($sql2);
 $row = $result2->fetch_assoc();
 $userId=$row['id'];
// echo '</br>userId'.$userId.'</br>';
  $sql3="INSERT INTO `pointslevel` (`user_id`, `level`, `points`) VALUES ($userId, 'A', 0)";
    
 $result3 = $conn->query($sql3);