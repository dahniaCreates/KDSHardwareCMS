<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 4, 2021
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

        if (isset($_GET['id'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  
        $query = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $statement = $db->prepare($query);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
                    
        $statement->execute();
        $category = $statement->fetch();

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
      <form class="container formborder" action="process_post.php" method="post" enctype='multipart/form-data'>
         <fieldset>
            <h3>Update or Delete Category</h3>
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <div class="forminput">
               <label for="category_name">Category Name</label>
               <input name="category_name" id="category_name" value="<?= $category['category_name'] ?>">
            </div>
            <div class="forminput">
               <label for='uploadedfile'>Image filename:</label>
               <input type='file' name='uploadedfile' id='uploadedfile'>
            </div>
            <?php if(!empty($category['images'])) :?>
            <div class="forminput">
               <label for='currentfile'>Current File:<?=$category['images']?></label>
                <small>
                     <a href="processimagedelete.php?id=<?=$category['id']?>">Delete Image</a>
               </small>
            </div>
         <?php endif?>
            <div class="forminput formbutton">
               <input type="submit" class="btn btn-primary updelbtn" name="command" value="Update" />

               <input type="submit" class="btn btn-primary updelbtn" name="command" value="Delete" onclick= "return confirm('Are you sure you wish to delete this category?')" />
            </div>
         </fieldset>
      </form>
      <?php endif?>
     <?php include('footer.php') ?>
   </body>
</html>

