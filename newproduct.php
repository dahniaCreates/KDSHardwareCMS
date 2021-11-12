<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 6, 2021
    Updated on: November 11, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
   require('connect.php');

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
        header("Location: index.php");
        exit;
      }
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
      <form class="container formborder" method="post" action="processnewproduct.php" enctype='multipart/form-data'>
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