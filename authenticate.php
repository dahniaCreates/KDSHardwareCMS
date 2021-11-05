<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 3, 2021
    Updated on: November 3, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->

<?php 
  //Defines the username and passowrd to be used for protected pages.
  define('ADMIN_LOGIN','admin'); 
  define('ADMIN_PASSWORD','password01'); 
  //Authorized user to login to access certain features if username and password are correct.
  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) 
      || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN) 
      || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) { 
    header('HTTP/1.1 401 Unauthorized'); //Redirects user if username or password is incorrect.
    header('WWW-Authenticate: Basic realm="Our Blog"'); 
    exit("Access Denied: Username and password required.");//Error message if username or password is incorrect.
  }    
?>
