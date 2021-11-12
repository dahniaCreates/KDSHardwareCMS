<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 11, 2021
    Updated on: November 11, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php 

session_start();

session_unset();

session_destroy();

header("Location: index.php");
?>