<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: November 10, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->

<?php
if(isset($_POST["submit"])){  
  
if(!empty($_POST['username']) && !empty($_POST['password'])) {  
    $user_username=$_POST['username'];  
    $user_password=$_POST['password'];  
  
    require('connect.php');
    
    $query= "SELECT * FROM users";  
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
    
      if($user_username == $stored_username && $user_password == $stored_password)  
      {  
        session_start();  
        $_SESSION['user']=$user_username; 
        $_SESSION['role']= $stored_role; 
      /* Redirect browser */  
      header("Location: index.php");
      exit;  
      }  
    }
  }
}
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
  <div class="conatiner" style="margin-left:auto; margin-right:auto; width:50%; margin-top: 30px; border-style: solid; padding: 20px; border-color: grey;">
    <h3 style="text-align: center;">Login</h3>
     <form action="login.php" method="post">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name = "username" value= "" placeholder="Enter username">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name= "password" value="" placeholder="Password">
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="rememberme">
    <label class="form-check-label" for="rememberme" name="rememberme">Remember me</label>
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>
  </div> 
</body>
</html>