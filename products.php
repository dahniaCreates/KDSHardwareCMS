<!--
    Final Project
    Name: Dahnia Simon
    Created on: November 3, 2021
    Updated on: November 3, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    //Connection to the database
    require('connect.php');
    
    /*Build and prepares SQL records for retrival in reverse chronological order and with
      a limit of 5 records only. */
    $query = "SELECT * FROM categories ORDER BY category_name ASC";
    $statement = $db->prepare($query);

    //Executes the SELECT query.
    $statement->execute(); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KDS Hardware Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    
    <h1>KDS Hardware Store</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">KDS Hardware</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
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
    
      <div class= "row">
        <?php while($row = $statement->fetch()): ?>
        <div class="col-sm-4 mb-4">
        <div class="card">
        <a href="items.php?id=<?="{$row['id']}"?>">
          <img class="card-img-top" src="images/<?=$row['images']?>" alt="<?= $row['category_name'] ?> Thumbnail Photo">
        </a>
        <div class="card-body">
        <h5 class="card-title"><a href="items.php?id=<?="{$row['id']}"?>"><?= $row['category_name'] ?></a></h5>
         <small>
                <a href="updatecategory.php?id=<?="{$row['id']}"?>">Update Category</a>
         </small>
      </div>
      </div>
      </div>
      <?php endwhile ?>
      </div>


    <a class="btn btn-primary" href="newcategory.php" role="button">New Category</a>

    <footer>
    <div class="conatiner" style="padding-top:80px; background-color:grey; margin-top:20px;">
    <div class="row">
    <div class="col" style="text-align: center;">
      COMPANY
        <div>
            <a href="#">About Us</a>
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