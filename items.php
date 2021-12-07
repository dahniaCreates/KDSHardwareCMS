<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 03, 2021
    Updated on: December 06, 2021
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
    
    if (isset($_GET['id'])) {
      $query = "SELECT * FROM products WHERE categoryId = :id";
      $statement = $db->prepare($query);

      $query_two = "SELECT * FROM categories WHERE id = :id";
      $selection = $db->prepare($query_two);
      
      $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
      
      $statement->bindValue('id', $id, PDO::PARAM_INT);
      $selection->bindValue('id', $id, PDO::PARAM_INT);

      $statement->execute();
      $selection->execute();

      $row_items = $selection->fetch();
      $categoryname = $row_items['category_name'];

      if($statement->rowCount() == 0){
        header("Location: /wd2/finalProject/newproductinsert");
        exit;
      }
  }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
     <?php include('subpage_nav.php')?>
   </head>
   <body>
      <h2><?=$categoryname?></h2>
      <div class="container">
      <div class= "row">
         <?php while($row = $statement->fetch()): ?>
         <div class="col-sm-4 mb-4">
            <div class="card imagegallery">
               <a href="/wd2/finalProject/items/item/<?=$row['id']?>">
               <img class="card-img-top" src="/wd2/finalProject/images/<?=$row['images']?>" alt="<?= $row['productName'] ?> Image" onerror="this.onerror=null; this.src='/wd2/finalProject/images/noimage.jpg'">
               </a>
               <div class="card-body">
                  <a href="/wd2/finalProject/items/item/<?=$row['id']?>" style="text-decoration: none; color: #000;">
                     <p><?= $row['productName'] ?></p>
                  </a>
                  <h5>$<?= $row['price'] ?></h5>
                  <?php if(isset($_SESSION['user']) && $_SESSION['role'] == "admin"): ?>
                  <small>
                  <a href="/wd2/finalProject/updateproducts/<?="{$row['id']}"?>" role="button" class="btn btn-dark">Update</a>
                  </small>
                  <?php endif?>
               </div>
            </div>
         </div>
         <?php endwhile ?>
      </div>
      <?php if(isset($_SESSION['user']) && $_SESSION['role'] == "admin"): ?>
      <small>
      <a role="button" class="btn btn-dark" href="/wd2/finalProject/newproduct/<?="{$_GET['id']}"?>">Add Product</a>
      </small>
      <?php endif?>
   </div>
     <?php include('footer.php') ?>
   </body>
</html>


