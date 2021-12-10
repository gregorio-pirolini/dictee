<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//openfolder
$dir    = 'D';


if ($handle = opendir('D'))
{
    /* Create a new directory for sanity reasons*/
   

    /*Iterate the files*/
    while (false !== ($file = readdir($handle)))
    {
          if ($file != "." && $file != "..")
          {
            echo nl2br ('["'.substr($file, 0, -4).'","'.$dir.'"],</br>')  ;  
                    
          }
    }
    closedir($handle);
}
 
//renamefiles