<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 24, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    session_start();
    require('connect.php');

   if(isset($_SESSION['user']))
   {
      $query = "SELECT * FROM users WHERE username = :username";
      $username = $_SESSION['user'];
      $statement = $db->prepare($query);

      $statement->bindValue(':username', $username);
      $statement->execute(); 

      $row= $statement->fetch();
      $customerid = $row['customerid'];

      $querytwo = "SELECT * FROM diys WHERE customerid = :customerid";
      $statementtwo = $db->prepare($querytwo);

      $customerid = filter_input(INPUT_GET, 'customerid', FILTER_SANITIZE_NUMBER_INT);

      $statementtwo->bindValue('customerid', $customerid, PDO::PARAM_INT);

      $statementtwo->execute();  
      $rowselect = $statementtwo->fetch();
      $title = $rowselect['title'];
   }
    
    if (isset($_GET['customerid'])) {
      $query = "SELECT * FROM diys WHERE customerid = :customerid ORDER BY date DESC";

      $statement = $db->prepare($query);
      
      $customerid = filter_input(INPUT_GET, 'customerid', FILTER_SANITIZE_NUMBER_INT);
      
      $statement->bindValue('customerid', $customerid, PDO::PARAM_INT);
    
      $statement->execute();  


      if($statement->rowCount() == 0){

        header("Location: newdiypost.php");
        exit;
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
    <?php include('header_and_nav.php')?>
   </head>
   <body>
    <div class = "container">
       <a class="btn btn-dark" href="/wd2/finalProject/newdiypost/<?=$customerid?>" role="button" 
               <?php if(isset($_SESSION['user']) && $_SESSION['role'] != "customer"): ?> style="display:none;" 
               <?php endif?>>New Post
        </a>
    </div>      
      <?php while($row = $statement->fetch()): ?>
                <?php 
                /*Retrieves the time_stamp from the fetch statement to the database,
                  converts the timestamp to a string and formats it using the date function.*/
                    $timestamp = $row['date']; 
                    $date = strtotime($timestamp);
                    $formatted_date = date('F j,Y, g:i a', $date);
                ?>
      <div class="container">
        <div class="card mt-4">
          <div class="card-body">
              <h4 class="card-title"><?=$row['title']?></h4>
              <p class="card-text"><?=$row['description']?></p>
              <p class="card-text"><small class="text-muted">Last updated <?=$formatted_date?></small></p>
              <a class="btn btn-dark" href="/wd2/finalProject/mydiys/updatediypost/<?=$row['id']?>/<?=$row['slugtitle']?>" role="button" 
               <?php if(isset($_SESSION['user']) && $_SESSION['role'] != "customer"): ?> style="display:none;" 
               <?php endif?>>Update Post
            </a>
            </div>
            <img class="card-img-bottom" src="/wd2/finalProject/images/<?=$row['image']?>" alt="Card image cap" onerror="this.onerror=null; this.src='/wd2/finalProject/images/noimage.jpg'">
        </div>
      </div>
    <?php endwhile ?>
   <?php include('footer.php') ?>
</body>
</html>