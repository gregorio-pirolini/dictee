<?php
require("php/db_connect.php");
// At the top of the page we check to see whether the user is logged in or not
    if(empty($_SESSION['user']))
    {
        // If they are not, we redirect them to the login page.
        header("Location: login.php");
        
        // Remember that this die statement is absolutely critical.  Without it,
        // people can view your members-only content without logging in.
       die("Redirecting to login.php");
    }
    
    // Everything below this point in the file is secured by the login system
    
    // We can display the user's username to them by reading it from the session array.  Remember that because
    // a username is user submitted content we must use htmlentities on it before displaying it to the user.
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dictée Magique</title>
<link rel="icon" href="pix/dictee_yZp_icon.ico" type="image/x-icon" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" href="css/main.css"/> 
<link rel="stylesheet" type="text/css" href="css/component.css" /> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script type="text/javascript" src="js/modernizr.custom.js"></script>
<script src="http://www.youtube.com/player_api"></script>
<script type="text/javascript" src="js/variables.js"></script>
<script type="text/javascript" src="js/dmWeb.js"></script>

</head>
<body>
   
    
    
<div id="clickMe">
    <div id='header'>
        <ul>
       
      <li id="nameUser"> </li>  
     <li id='level'>Niveau&nbsp;<span id="levelUser"></span>  </li>   
     
     
     
     <li id='points'>0 Pts</li>
     <li id="sound">Son: 
    <div id="slider">
  <div id="custom-handle" class="ui-slider-handle"></div></div>
</li>
<li id="words">Mot: <span id="wordNumber">0</span>/15</li>
</ul> </div>
    <div id='spellwordsBox'>
<input type="text" id="spelledWords">
 </div>
  

 <div id="dialog-message" title="Download complete">
  <p>
 Your files have downloaded successfully into the My Downloads folder.
  </p>
  <p>
    Currently using <b>36% of your storage space</b>.
  </p>
</div>
</div>
</body></html>