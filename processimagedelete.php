<?php
	if(isset($_GET['id']))
		{
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            require('connect.php');

            $query = "UPDATE categories SET images = NULL WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);

            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            
            $statement->execute();
            
            header("Location: products.php");
		}
?>