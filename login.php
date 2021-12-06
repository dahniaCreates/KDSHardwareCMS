<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: December 05, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->

<?php

if(isset($_SESSION['user']))
   {
      $query = "SELECT * FROM users WHERE username = :username";
      $username = $_SESSION['user'];
      $statement = $db->prepare($query);

      $statement->bindValue(':username', $username);
      $statement->execute(); 

      $row= $statement->fetch();
      $customerid = $row['customerid'];
   }
   
if(isset($_POST["submit"])){  
  
   if(!empty($_POST['username']) && !empty($_POST['password'])) {  
       $user_username=$_POST['username'];  
       $user_password=$_POST['password'];  
     
       require('connect.php');
       
       $query= "SELECT * FROM users WHERE username = '$user_username'";  
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
       
         if($stored_username === $user_username  && password_verify($user_password, $stored_password))  
         {  
           session_start();  
           $_SESSION['user']=$user_username; 
           $_SESSION['role']= $stored_role; 

           header("Location: /wd2/finalProject/home");
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
      <?php include('header_and_nav.php')?>
   </head>
   <body>
      <div class= "container formborder">
         <h3 class="formheading">Login</h3>
         <form action="/wd2/finalProject/login" method="post">
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
      <?php include('footer.php') ?>
   </body>
</html>