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
        <div class="card">
          <div class="card-body">
              <h5 class="card-title"><?=$row['title']?></h5>
              <p class="card-text"><?=$row['description']?></p>
              <p class="card-text"><small class="text-muted">Last updated <?=$formatted_date?></small></p>
            </div>
            <img class="card-img-bottom" src="images/<?=$row['image']?>" alt="Card image cap">
        </div>
    <?php endwhile ?>
   <?php include('footer.php') ?>
</body>
</html>