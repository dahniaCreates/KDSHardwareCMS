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
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
    <?php include('header_and_nav.php')?>
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
                <div class="container">
        <div class="card">
          <div class="card-body">
              <h4 class="card-title"><?=$row['title']?></h4>
              <p class="card-text"><?=$row['description']?></p>
              <p class="card-text"><small class="text-muted">Last updated <?=$formatted_date?></small></p>
              <a class="btn btn-dark" href="updatediypost.php?id=<?="{$row['id']}"?>" role="button" 
               <?php if(isset($_SESSION['user']) && $_SESSION['role'] != "customer"): ?> style="display:none;" 
               <?php endif?>>Update Post
            </a>
            </div>
            <img class="card-img-bottom" src="images/<?=$row['image']?>" alt="Card image cap" onerror="this.onerror=null; this.src='images/noimage.jpg'">
        </div>
      </div>
    <?php endwhile ?>
   <?php include('footer.php') ?>
</body>
</html>