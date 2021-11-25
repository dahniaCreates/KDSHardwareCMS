<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    session_start();
    require('connect.php');

        if (isset($_GET['id'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
       
        $query = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $statement = $db->prepare($query);
       
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();            
        $product = $statement->fetch();

        if($statement->rowCount() == 0){
         header("Location: products.php");
         exit;
        }
    }
    else{
        $id = false;
    }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <?php include('header_and_nav.php')?>
   </head>
   <body>
      <?php if($id): ?>
      <form class="container formborder" action="process_productupdate.php" method="post" enctype='multipart/form-data'>
         <fieldset>
            <h3>Update or Delete Product</h3>
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <div class="forminput">
               <label for="productName">Product Name</label>
               <input name="productName" id="productName" value="<?= $product['productName'] ?>">
            </div>
            <div class="forminput">
               <label for="price">Price</label>
               <input name="price" id="price" value="<?= $product['price'] ?>">
            </div>
            <div class="forminput">
               <input type="hidden" name="categoryId" id="categoryId" value="<?= $product['categoryId'] ?>" readonly>
            </div>
            <div class="forminput">
               <label for='uploadedfile'>Image filename:</label>
               <input type='file' name='uploadedfile' id='uploadedfile'>
            </div>
             <?php if(!empty($product['images'])) :?>
            <div class="forminput">
               <label for='currentfile'>Current File:<?=$product['images']?></label>
                <small>
                     <a href="processimagedeleteproduct.php?id=<?=$product['id']?>">Delete Image</a>
               </small>
            </div>
         <?php endif?>
            <div class="forminput formbutton">
               <input type="submit" name="command" value="Update" class="btn btn-primary updelbtn" />
               <input type="submit" name="command" value="Delete" class="btn btn-primary updelbtn" onclick= "return confirm('Are you sure you wish to delete this category?')" />
            </div>
         </fieldset>
      </form>
      <?php endif?>
    <?php include('footer.php') ?>
   </body>
</html>

