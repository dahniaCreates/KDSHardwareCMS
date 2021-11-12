<!--
    Final Project
    Name: Dahnia Simon
    Created on: November 11, 2021
    Updated on: November 11, 2021
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
      <link rel="stylesheet" href="styles.css">
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
               <?php endif?>>Login
            </a>
            <?php if(isset($_SESSION['user'])): ?>   
            <a class="btn btn-dark" href="logout.php" role="button" >Logout</a>
            <?php endif?>
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
      <div class="container">
         <div class="row mb-4">
         <div class="col">
             <h3>MISSION STATEMENT</h3>
               <p>
                  We are dedicated to being the primary provider for all products and services required by our customers,
                  through excellent and speedy service and high quality products.
               </p>
         </div>        
      </div>
      <div class="row mb-4">
         <div class="col">
             <h3>VISION STATEMENT</h3>
               <p>
                  We aspire to be recognized as the hardware store of choice for everyone in Canada. 
               </p>
         </div>        
      </div>
      <div class="row mb-4">
         <div class="col">
             <h3>BUSINESS HISTORY</h3>
               <p>
                  The KDS Hardware Store was founded in 2016 by Dulliva, Kerine and Dahnia Simon.</br>
                  The hardware is located in rural Winnipeg and was developed as a means to make hardware
                  and building products readily available to individuals living outside the city. The business
                  started out very small but due to support from the community, it has expanded and hired 
                  five (5) employees.
               </p>
         </div>        
      </div>
      </div>      
      <footer>
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