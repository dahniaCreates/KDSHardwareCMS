<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 6, 2021
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

  if (isset($_GET['categoryId'])) {

      $query = "SELECT * FROM categories WHERE id = :categoryId";
      $statement = $db->prepare($query);

      $categoryid = filter_input(INPUT_GET, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
      
      $statement->bindValue('categoryId', $categoryid, PDO::PARAM_INT);
      $statement->execute();
      
      $row = $statement->fetch();

      $categoryId = $row['id'];
      $categoryName = $row['category_name']; 

      if($statement->rowCount() == 0){
        header("Location: /wd2/finalProject/home");
        exit;
      }
  }

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
       <?php include('subpage_nav.php')?>
   </head>
   <body>
      <form class="container formborder" method="post" action="/wd2/finalProject/newproduct/processnewproduct" enctype='multipart/form-data'>
         <fieldset>
            <h3>Create New Product for <?=$categoryName?></h3>
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
            <input type="hidden" name="categoryId" id="categoryId" value="<?=$categoryId?>" readonly/>
            <div class="formbutton">
               <button type="submit" class="btn btn-primary" name="submit">Create</button>
            </div>
         </fieldset>
      </form>
     <?php include('footer.php') ?>
   </body>
</html>