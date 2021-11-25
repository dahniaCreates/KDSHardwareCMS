<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 25, 2021
    Updated on: November 25, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
	if(isset($_GET['id']))
		{
            require('connect.php');
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            $query = "SELECT * FROM diys WHERE id = :id";

            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
      
            $statement->execute(); 
            $row = $statement->fetch();
            $path = "images";         
            $filename = $path."/".$row['image'];
            if(file_exists($filename))
            {
                unlink($filename);
            }
            $customerid = $row['customerid'];

            $querytwo = "UPDATE diys SET image = NULL WHERE id = :id LIMIT 1";
            $statement = $db->prepare($querytwo);

            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            
            $statement->execute();
            
            header("Location: mydiys.php?customerid=$customerid");
		}
?>