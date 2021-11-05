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
    
    <h1>KDS Hardware Store</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">KDS Hardware</a>
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
    <?php while($row = $statement->fetch()): ?>
        <div>
            <ul>
                <li><?= $row['category_name'] ?></li>
            </ul>
        </div>
    <?php endwhile ?>
</body>
</html>

