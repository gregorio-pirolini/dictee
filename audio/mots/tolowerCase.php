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
               
                     $newName=strtolower ($file );

               /*Rename the old file accordingly*/
               rename($dir ."/" . $file,$dir ."/" .$newName);
          }
    }
    closedir($handle);
}
 $files1 = scandir($dir);
 $scanned_directory = array_diff($files1, array('..', '.'));
print_r($scanned_directory);
//renamefiles