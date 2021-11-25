<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 6, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
     <?php include('header_and_nav.php')?>
   </head>
   <body>
      <form class="container formborder" method="post" action="processnewcategory.php" enctype='multipart/form-data'>
         <fieldset>
            <h3>Create New Product Category</h3>
            <div class="forminput">
               <label for="category_name">Category Name:</label>
               <input name="category_name" id="category_name" />
            </div>
            <div class="forminput">
               <label for='uploadedfile'>Image filename:</label>
               <input type='file' name='uploadedfile' id='uploadedfile'>
            </div>
            <div class="formbutton">
               <button type="submit" class="btn btn-primary" name="submit">Create</button>
            </div>
         </fieldset>
      </form>
      </div>
     <?php include('footer.php') ?>
   </body>
</html>