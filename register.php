<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 23, 2021
    Updated on: November 23, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->

<?php
if(isset($_POST['submit'])){  
  
   if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {  
     
       require('connect.php');

      $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $query= "INSERT INTO users(firstName, lastName, username, password, emailAddress, usertype) VALUES (:firstName, :lastName, :username, :password, :emailAddress, :usertype)";  
      $statement = $db->prepare($query);

      $statement->bindValue(":firstName", $firstname);
      $statement->bindValue(":lastName", $lastname); 
      $statement->bindValue(":username", $username);  
      $statement->bindValue(":password", $hashed_password);  
      $statement->bindValue(":emailAddress", $email);  
      $statement->bindValue(":usertype", $usertype);   

      $statement->execute();
       
      header("Location: login.php");
      exit;          
   }   
   else
   {
      header("Location: registration.php?error=All fields are required fields");
      exit();
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
      <div class= "container formborder">
         <h3 class="formheading">Register</h3>
         <form action="register.php" method="post">
            <div class="forminput">
               <label for="firstname">First Name</label>
               <input type="text" class="form-control" id="firstname" name = "firstname" value= "" placeholder="First Name">
            </div>
            <div class="forminput">
               <label for="lastname">Last Name</label>
               <input type="text" class="form-control" id="lastname" name = "lastname" value= "" placeholder="Last Name">
            </div>
            <div class="forminput">
               <label for="email">Email</label>
               <input type="text" class="form-control" id="email" name = "email" value= "" placeholder="Email">
            </div>
             <div class="forminput">
               <label for="username">Username</label>
               <input type="text" class="form-control" id="username" name = "username" value= "" placeholder="Enter username">
            </div>
            <div class="forminput">
               <label for="password">Password</label>
               <input type="password" class="form-control" id="password" name= "password" value="" placeholder="Password">
            </div>
            <input type="hidden" name="usertype" id="usertype" value="customer" readonly/>
            <div>
               <?php if (isset($_GET['error'])): ?>
                  <p class="error"><?php echo $_GET['error'] ?></p>
               <?php endif?>
            </div>
            <div class="formbutton">
               <button type="submit" class="btn btn-primary" name="submit">Register</button>
            </div>
         </form>
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