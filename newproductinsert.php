<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 6, 2021
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

  $query = "SELECT * FROM categories";
  $statement = $db->prepare($query);

  $statement->execute(); 

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <?php include('header_and_nav.php')?>
   </head>
   <body>
      <form class="container formborder" method="post" action="processnewproductinsert.php" enctype='multipart/form-data'>
         <fieldset>
            <legend>Create New Product</legend>
            <div class="forminput">
               <label for="productName">Product Name</label>
               <input name="productName" id="productName" />
            </div>
            <div class="forminput">
               <label for="price">Price</label>
               <input name="price" id="price" />
            </div>
            <div class="forminput">
               <label for='uploadedfile'>Image filename:</label>
               <input type='file' name='uploadedfile' id='uploadedfile'>
            </div>
            <label class="forminput" for="categoryId">Product Category:</label>
            <select id="categoryId" name="categoryId">
               <?php while($row = $statement->fetch()): ?>
               <option value="<?=$row['id']?>"><?= $row['category_name'] ?></option>
               <?php endwhile ?>
            </select>
            <div class="formbutton">
               <button type="submit" class="btn btn-primary" name="submit">Create</button>
            </div>
         </fieldset>
      </form>
      <?php include('footer.php') ?>
   </body>
</html>