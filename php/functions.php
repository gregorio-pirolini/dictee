<?php
function wordslist($dataAll) {
    if (count($dataAll) < 1) { 
        return ''; 
    }
    $str = "AND w.word not in (";
    for ($i = 0; $i < count($dataAll); $i++) {
        // Enclose each word in single quotes and escape any quotes within the words
        $str .= "'" . addslashes($dataAll[$i]['word']) . "',";
    }
    // Remove the last comma and close the parentheses
    $modifiedString = substr($str, 0, -1) . ")";
    
    return $modifiedString;
}


function doLevels($letter){
    if($letter=='A'){
       $levels="w.`level`='A'"; 
    }else if ($letter=='B'){  
$levels="(w.`level`='A' OR w.`level`='B')";
 }else if ($letter=='C'){  
$levels="(w.`level`='A' OR w.`level`='B' OR w.`level`='C')";
}else if ($letter=='D'){  
$levels="(w.`level`='A' OR w.`level`='B' "
        . "OR w.`level`='C' OR w.`level`='D')";
}
//  echo $levels;
return $levels;
}

function calculatePercent($totalA, $totalG){
     //$totalA -->100
     //$totalG -->$x
     
     $x=($totalG*100)/$totalA;
     return $x;
 }
 
 function doLevelsLevels($letter){
   if($letter=='A'){
        $levels="A"; 
   }if($letter=='B'){
        $levels="A' or level='B"; 
   }if($letter=='C'){
       $levels="A' or level='B' or level='C"; 
   }if($letter=='D'){
        $levels="A' or level='B' or level='C' or level=D"; 
   } 
 
    return $levels; 
 }
 
 function strip_tags_trim($var) {
     $secureVar = strip_tags(trim($var));
     return $secureVar;    
 }