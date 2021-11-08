<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 1, 2021
    Updated on: November 7, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KDS Hardware Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <div class="row justify-content-between">
    <div class="col-auto mr-auto">
      <h1>KDS Hardware Store</h1>
    </div>
    <div class="col-auto">
        <?php if(isset($_SESSION['user'])): ?>            
        <?='Welcome back, ' . $_SESSION['user']?>
    <?php endif?>
     <a class="btn btn-dark" href="login.php" role="button" 
     <?php if(isset($_SESSION['user'])): ?> style="display:none;" 
     <?php endif?>>Login</a>
    </div>
  </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">KDS Hardware</a>
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
    <img src="images/mainpage.jpg" alt="tools"style="width:100% "/>

<div class="container" style="margin-top: 100px">
    <div class="row justify-content-md-center">
        <div class="col" style="font-size: 20px;">
             <h2 style="text-align: center; margin-bottom: 25px; font-size:40px;">MAKING YOUR HOME OUR PRIORITY</h2>
            The KDS Hardware prides itself on supplying difficult to find products to meet all the needs its customers.</br>
            We carry items to improve every room in your homes; from gardening supplies, to lumber, paints, tools, fixtures and more. 
            <div style="margin-top: 60px;">
                <button type="button" class="btn btn-primary" style="padding:12px;">Shop Now</button>
            </div>

        </div>
        <div class="col">
               <img src="images/lumberstackmain.jpg" alt="lumber stack" style="width:100%; height: 400px; padding-left: 60px;"/>  
        </div>
    </div>
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
</div>
</body>
</html>