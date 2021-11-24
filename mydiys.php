<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 24, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    require('connect.php');
    
    if (isset($_GET['customerid'])) {
      $query = "SELECT * FROM diys WHERE customerid = :customerid";

      $statement = $db->prepare($query);
      
      $customerid = filter_input(INPUT_GET, 'customerid', FILTER_SANITIZE_NUMBER_INT);
      
      $statement->bindValue('customerid', $customerid, PDO::PARAM_INT);
    
      $statement->execute();      

      if($statement->rowCount() == 0){

        header("Location: createnewdiypost.php");
        exit;
      }
  }
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>KDS Hardware Store</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css">
      <div class="row justify-content-between">
         <div class="col-auto mr-auto">
            <h1>KDS Hardware Store</h1>
         </div>
         <div class="col-auto">
            <?php if(isset($_SESSION['user'])): ?>            
            <?='Welcome back, ' . $_SESSION['user']?>
            <?php endif?>
            <a class="btn btn-dark" href="register.php" role="button" 
               <?php if(isset($_SESSION['user'])): ?> style="display:none;" 
               <?php endif?>>Register
            </a>
            <a class="btn btn-dark" href="login.php" role="button" 
               <?php if(isset($_SESSION['user'])): ?> style="display:none;" 
               <?php endif?>>Login
            </a>
            <?php if(isset($_SESSION['user'])): ?>   
            <a class="btn btn-dark" href="logout.php" role="button" >Logout</a>
            <?php endif?>
         </div>
      </div>
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
                   <?php if(isset($_SESSION['user']) && $_SESSION['role'] == "customer"): ?>   
                  <li class="nav-item">
                     <a class="nav-link" href="mydiys.php?customerid=<?=$customerid?>">My DIYs</a>
                  </li>
               <?php endif?>
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
                <?php 
                /*Retrieves the time_stamp from the fetch statement to the database,
                  converts the timestamp to a string and formats it using the date function.*/
                    $timestamp = $row['date']; 
                    $date = strtotime($timestamp);
                    $formatted_date = date('F j,Y, g:i a', $date)
                ?>
        <div class="card">
          <div class="card-body">
              <h5 class="card-title"><?=$row['title']?></h5>
              <p class="card-text"><?=$row['description']?></p>
              <p class="card-text"><small class="text-muted">Last updated <?=$formatted_date?></small></p>
            </div>
            <img class="card-img-bottom" src="images/<?=$row['image']?>" alt="Card image cap">
        </div>
    <?php endwhile ?>
</body>
</html>