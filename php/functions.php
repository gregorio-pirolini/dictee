<?php


function doLevels($letter){
if($letter=='A'){
    $levels="w.`level` in ('A')"; 
}else if ($letter=='B'){  
    $levels="w.`level` in ('A','B')"; 
}else if ($letter=='C'){  
    $levels="w.`level` in ('A','B','C')"; 
}else if ($letter=='D'){  
    $levels="w.`level` in ('A','B','C','D')"; 
}else if ($letter=='E'){  
    $levels="w.`level` in ('B','C','D','E')"; 
}else if ($letter=='F'){  
    $levels="w.`level` in ('C','D','E','F')"; 
}else if ($letter=='G'){  
     $levels="w.`level` in ('D','E','F','G')"; 
}else if ($letter=='H'){  
   $levels="w.`level` in ('E','F','G','H')"; 
}else if ($letter=='I'){  
   $levels="w.`level` in ('E','F','G','H','I')";
}else if ($letter=='J'){  
   $levels="w.`level` in ('E','F','G','H','I','J')";  
}else if ($letter=='K'){  
   $levels="w.`level` in ('E','F','G','H','I','J','K')";  
}else if ($letter=='L'){  
   $levels="w.`level` in ('E','F','G','H','I','J','K','L')";  
   } //  echo $levels;
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