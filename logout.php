<?php
require("php/db_connect.php");
unset($_SESSION['user']);
header("Location: login.php");
die("Redirecting to: login.php"); 
