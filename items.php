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
    
    if (isset($_GET['id'])) {
      // Build and prepare SQL String with :id placeholder parameter.
      $query = "SELECT * FROM products WHERE categoryId = :id";
      $statement = $db->prepare($query);

      $query_two = "SELECT * FROM categories WHERE id = :id";
      $selection = $db->prepare($query_two);
      
      // Sanitize $_GET['id'] to ensure it's an integer.
      $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
      
      // Bind the :id parameter in the query to the sanitized
      // $id specifying a binding-type of Integer.
      $statement->bindValue('id', $id, PDO::PARAM_INT);
      $selection->bindValue('id', $id, PDO::PARAM_INT);

      $statement->execute();
      $selection->execute();

      $row_items = $selection->fetch();
      $categoryname = $row_items['category_name'];

      //Ensures that the id specified in the GET returns at least one row.
      if($statement->rowCount() == 0){
        //Redirects the user to the index page if the id value is invalid.
        header("Location: newproductinsert.php");
        exit;
      }
  }
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
  <h2><?=$categoryname?></h2>
   <div class= "row">
        <?php while($row = $statement->fetch()): ?>
        <div class="col-sm-4 mb-4">
        <div class="card">
        <a href="item.php?id=<?="{$row['id']}"?>">
          <img class="card-img-top itemgallery" src="images/<?=$row['images']?>" alt="<?= $row['productName'] ?> Image">
        </a>
        <div class="card-body">
        <!-- <h5 class="card-title"><a href="item.php?id=<?="{$row['id']}"?>"><?= $row['productName'] ?></a></h5> -->
        <p><?= $row['productName'] ?></p>
        <h5>$<?= $row['price'] ?></h5>
          <small>
                <a href="updateproducts.php?id=<?="{$row['id']}"?>">Update</a>
            </small>
      </div>
      </div>
      </div>
      <?php endwhile ?>
      </div>

      <small>
          <a href="newproduct.php?categoryId=<?="{$_GET['id']}"?>">Add Product</a>
      </small>
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


