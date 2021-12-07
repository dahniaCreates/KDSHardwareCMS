<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 10, 2021
    Updated on: December 05, 2021
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
      $query = "SELECT * FROM products WHERE id = :id";
      $statement = $db->prepare($query);
      
      $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
      
      $statement->bindValue('id', $id, PDO::PARAM_INT);
    
      $statement->execute();      

      $row= $statement->fetch();
      $image = $row['images'];
      $productname = $row['productName'];
      $price = $row['price'];

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
      <div class="container" style="margin-top: 100px">
         <div class="row justify-content-md-center">
            <div class="col">
               <img class="singleitemimage" src="/wd2/finalProject/images/<?=$image?>" alt="<?= $productname ?> Image" onerror="this.onerror=null; this.src='/wd2/finalProject/images/noimage.jpg'">
            </div>
            <div class="col singleitemcontainer">
               <p class="singleitemproductname"><?= $productname?></p>
               <h3>$<?= $price ?><sub>each</sub></h3>
            </div>
         </div>
      </div>
         <?php include('footer.php') ?>
   </body>
</html>