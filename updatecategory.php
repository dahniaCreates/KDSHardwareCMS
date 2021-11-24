<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 4, 2021
    Updated on: November 11, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php

    require('connect.php');

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
      <title>KDS Hardware Store</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css">
      <h1>KDS Hardware Store</h1>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
            <a class="navbar-brand" href="index.php">KDS Hardware</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="products.php">Products</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="aboutus.php">About Us</a>
                  </li>
               </ul>
               <form class="d-flex">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
               </form>
            </div>
         </div>
      </nav>
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
      <footer class="fixed-bottom">
         <div class="conatiner" style="padding-top:80px; background-color:grey; margin-top:20px;">
            <div class="row">
               <div class="col" style="text-align: center;">
                  COMPANY
                  <div>
                     <a href="aboutus.php">About Us</a>
                  </div>
               </div>
               <div class="col" style="text-align: center;">
                  CONTACT
                  <p>kdshardware2020@gmail.com</p>
                  <p>+204 453 6175</p>
               </div>
               <div class="col" style="text-align: center;">
                  ADDRESS
                  <p>
                     109 Princess Street</br>
                     Winnipeg MB</br>
                     R4B 1EX
                  </p>
               </div>
            </div>
         </div>
      </footer>
   </body>
</html>

