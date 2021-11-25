<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 25, 2021
    Updated on: November 25, 2021
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
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
     <?php include('header_and_nav.php')?>
      <script type="text/javascript" src="tinymce/tinymce.min.js"></script>
      <script>
         tinymce.init({
               selector:'#myEditor'
            });         
      </script>
   </head>
   <body>
      <form class="container formborder" method="post" action="processnewdiypost.php?customerid=<?= $customerid?>" enctype='multipart/form-data'>
         <fieldset>
            <h3>Create New DIY Post</h3>
            <div class="forminput">
               <label for="title">Title</label>
               <input name="title" id="title" value="">
            </div>
            <div class="forminput">
              <label for="description">Description</label>
               <textarea class="form-control" name="description" id="myEditor"></textarea>
            </div>
           <div class="forminput">
               <input type="hidden" name="customerid" id="customerid" value="<?= $customerid?>" readonly>
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