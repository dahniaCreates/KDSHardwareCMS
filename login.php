<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: November 11, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->

<?php
if(isset($_POST["submit"])){  
  
   if(!empty($_POST['username']) && !empty($_POST['password'])) {  
       $user_username=$_POST['username'];  
       $user_password=$_POST['password'];  
     
       require('connect.php');
       
       $query= "SELECT * FROM users WHERE username = '$user_username' AND password = '$user_password'";  
       $statement = $db->prepare($query);
       $statement->execute();
       
      if($statement->rowcount() != 0)  
      {  
         while($row = $statement->fetch())  
         {  
           $stored_username=$row['username'];  
           $stored_password=$row['password']; 
           $stored_role = $row['usertype']; 
         }  
       
         if($stored_username === $user_username  && $stored_password === $user_password)  
         {  
           session_start();  
           $_SESSION['user']=$user_username; 
           $_SESSION['role']= $stored_role; 

           header("Location: index.php");
           exit;  
         }
         else if($stored_username != $user_username || $stored_password != $user_password){
              header("Location: login.php?error=Invalid username or password");
               exit();
         }  
      }
   }
   else
   {
      header("Location: login.php?error=Both password and username are required fields");
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
         <h3 class="formheading">Login</h3>
         <form action="login.php" method="post">
            <div class="forminput">
               <label for="username">Username</label>
               <input type="text" class="form-control" id="username" name = "username" value= "" placeholder="Enter username">
            </div>
            <div class="forminput">
               <label for="password">Password</label>
               <input type="password" class="form-control" id="password" name= "password" value="" placeholder="Password">
            </div>
            <div>
               <?php if (isset($_GET['error'])): ?>
                  <p class="error"><?php echo $_GET['error'] ?></p>
               <?php endif?>
            </div>
            <div class="formbutton">
               <button type="submit" class="btn btn-primary" name="submit">Submit</button>
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