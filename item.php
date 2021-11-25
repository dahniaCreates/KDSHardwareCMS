<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 10, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    require('connect.php');
    
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

        header("Location: newproductinsert.php");
        exit;
      }
  }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <?php include('header_and_nav.php')?>
   </head>
   <body>
      <div class="container" style="margin-top: 100px">
         <div class="row justify-content-md-center">
            <div class="col">
               <img class="singleitemimage" src="images/<?=$image?>" alt="<?= $productname ?> Image" onerror="this.onerror=null; this.src='images/noimage.jpg'">
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