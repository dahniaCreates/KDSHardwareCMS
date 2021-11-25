<!--
    Final Project
    Name: Dahnia Simon
    Created on: November 3, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    session_start();

    require('connect.php');

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

    $query = "SELECT * FROM categories ORDER BY category_name ASC";
    $statement = $db->prepare($query);

    $statement->execute(); 
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <?php include('header_and_nav.php')?>
   </head>
   <body>
      <div class="container">
      <div class= "row">
         <?php while($row = $statement->fetch()): ?>
         <div class="col-sm-4 mb-4">
            <div class="card imagegallery">
               <a href="items.php?id=<?="{$row['id']}"?>">
               <img class="card-img-top" src="images/<?=$row['images']?>" alt="<?= $row['category_name'] ?> Thumbnail Photo" onerror="this.onerror=null; this.src='images/noimage.jpg'">
               </a>
               <div class="card-body">
                  <h5 class="card-title"><a href="items.php?id=<?="{$row['id']}"?>"><?= $row['category_name'] ?></a></h5>
                  <?php if(isset($_SESSION['user']) && $_SESSION['role'] == "admin"): ?>
                  <small>
                     <a href="updatecategory.php?id=<?="{$row['id']}"?>">Update Category</a>
                  </small>
                  <?php endif?>
               </div>
            </div>
         </div>
         <?php endwhile ?>
      </div>
      <?php if(isset($_SESSION['user']) && $_SESSION['role'] == "admin"): ?>
      <a class="btn btn-primary" href="newcategory.php" role="button">New Category</a>
      <?php endif?>
   </div>
     <?php include('footer.php') ?>
   </body>
</html>