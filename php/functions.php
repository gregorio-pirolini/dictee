<?php

function doLevels($letter){
    if($letter=='A'){
       $levels="the_words.`level`='A'"; 
    }else if ($letter=='B'){  
$levels="(the_words.`level`='A' or the_words.`level`='B')";
 }else if ($letter=='C'){  
$levels="(the_words.`level`='A' or the_words.`level`='B' or the_words.`level`='C')";
}else if ($letter=='D'){  
$levels="(the_words.`level`='A' or the_words.`level`='B' "
        . "or the_words.`level`='C' or the_words.`level`='D')";
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
 
 function strip_tags_trim($var){
   $secureVar=strip_tags( trim( $var ) );
     return $secureVar;    
 }