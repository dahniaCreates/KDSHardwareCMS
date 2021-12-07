<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 27, 2021
    Updated on: December 06, 2021
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

   $searchword = filter_input(INPUT_POST, 'searchword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $search = "SELECT * FROM products WHERE productName LIKE :searchword ";
   $statement = $db->prepare($search);
   $statement->bindValue(':searchword', '%'.$searchword.'%');
   $statement->execute();

   
?>
<!DOCTYPE html>
<html lang="en">
   <head>
   <meta charset="utf-8">
   <?php include('subpage_nav.php')?>
   </head>
  <body>
   <?php while($row = $statement->fetch()):?>
      <div class="container" style="margin-top: 100px">
         <div class="row justify-content-md-center">
            <div class="col">
               <img class="singleitemimage" src="/wd2/finalProject/images/<?=$row['images']?>" alt="<?= $row['productName']?> Image" onerror="this.onerror=null; this.src='/wd2/finalProject/images/noimage.jpg'">
            </div>
            <div class="col singleitemcontainer">
               <p class="singleitemproductname"><?= $row['productName']?></p>
               <h3>$<?= $row['price'] ?><sub>each</sub></h3>
            </div>
         </div>
      </div>
   <?php endwhile?>
         <?php include('footer.php') ?>
   </body>
</html>