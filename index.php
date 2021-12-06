<!--
    Final Project
    Name: Dahnia Simon
    Created on: November 1, 2021
    Updated on: December 05, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    require('connect.php');
    session_start();

   if(isset($_SESSION['user']))
   {
      $query = "SELECT * FROM users WHERE username = :username";
      $username = $_SESSION['user'];
      $statement = $db->prepare($query);

      $statement->bindValue(':username', $username);
      $statement->execute(); 

      $row= $statement->fetch();
      $customerid = $row['customerid'];
   }

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <?php include('header_and_nav.php')?>
   </head>
   <body>
      <div class="main">
      <img src="images/mainpage.jpg" alt="tools"style="width:100% "/>
      <div class="container" style="margin-top: 100px">
         <div class="row justify-content-md-center">
            <div class="col" style="font-size: 20px;">
               <h2 style="text-align: center; margin-bottom: 25px; font-size:40px;">MAKING YOUR HOME OUR PRIORITY</h2>
               The KDS Hardware prides itself on supplying difficult to find products to meet all the needs its customers.</br>
               We carry items to improve every room in your homes; from gardening supplies, to lumber, paints, tools, fixtures and more. 
               <div style="margin-top: 60px;">
                  <a role="button" href="/wd2/finalProject/products" class="btn btn-primary" style="padding:12px;">Shop Now</a>
               </div>
            </div>
            <div class="col">
               <img src="images/lumberstackmain.jpg" alt="lumber stack" style="width:100%; height: 400px; padding-left: 60px;"/>  
            </div>
         </div>
      </div>
   </div>
   <?php include('footer.php') ?>
   </body>
</html>