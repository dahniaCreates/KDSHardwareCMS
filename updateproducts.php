<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
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

        if (isset($_GET['id'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
       
        $query = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $statement = $db->prepare($query);
       
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();            
        $product = $statement->fetch();

        if($statement->rowCount() == 0){
         header("Location: /wd2/finalProject/products");
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
      <?php include('subpage_nav.php')?>
   </head>
   <body>
      <?php if($id): ?>
      <form class="container formborder" action="/wd2/finalProject/updateproducts/processproductupdate" method="post" enctype='multipart/form-data'>
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
               <label for='currentfile'>
                  Current Image:<img src="/wd2/finalProject/images/<?=$product['images']?>" alt="<?=$product['images']?> Photo" style="width: 100px; height: 100px;" onerror="this.onerror=null; this.src='images/noimage.jpg'">                     
               </label>
                <small>
                     <a href="/wd2/finalProject/updateproducts/processimagedeleteproduct/<?=$product['id']?>">Delete Image</a>
               </small>
            </div>
         <?php endif?>
            <div class="forminput formbutton">
               <input type="submit" name="command" value="Update" class="btn btn-dark updelbtn" />
               <input type="submit" name="command" value="Delete" class="btn btn-dark updelbtn" onclick= "return confirm('Are you sure you wish to delete this category?')" />
            </div>
         </fieldset>
      </form>
      <?php endif?>
    <?php include('footer.php') ?>
   </body>
</html>

