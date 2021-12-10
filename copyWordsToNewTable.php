<?php

$dataAll=[]; 

$sql = "select id from words order by id ASC";

   $result = $conn->query($sql);  
   
   while ($row = $result->fetch_assoc()) {
    
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
  $sql1 = "INSERT INTO words_gregorio2 (words_id, words_number, last_asked)
VALUES ('$data', '1', '0');";  
    $result = $conn->query($sql1);  
}
 mysqli_close($conn); 
    
