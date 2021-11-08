<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: November 7, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
	require('authenticate.php');


	if($_POST)
	{
		if($_POST['command'] == 'Update')
		{
			
	        if (!empty($_POST['productName']) && !empty($_POST['price']) && !empty($_POST['categoryId']) && isset($_POST['id'])) {
	            // Sanitization of user input to filter out malicious characters.
	            $productname  = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	            $categoryid = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
	            $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
	            
	            require('connect.php');
	            // Build the parameterized SQL query and bind to the above sanitized values.
	            $query     = "UPDATE products SET productName = :productName, price = :price, categoryId = :categoryId WHERE id = :id LIMIT 1";
	            $statement = $db->prepare($query);
	            $statement->bindValue(':productName', $productname);
	            $statement->bindValue(':price', $price);
	            $statement->bindValue(':categoryId', $categoryid);          
	            $statement->bindValue(':id', $id, PDO::PARAM_INT);
	            
	            // Execute the INSERT.
	            $statement->execute();
	            
	            // Redirect to index page after update ans exit script.
	            header("Location: products.php");
	            exit;
	        }
		}
		else if($_POST['command'] == 'Delete')
		{
			//Retrives the id value in the URL and sanitizes it.
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            require('connect.php');
            //Builds and prepares the parameterized SQL query to delete the specified record based on the id value.
            $query = "DELETE FROM products WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);
            //Binds the placeholder :id value to the filtered id value and specifies the binding type as Integer.
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            
            // Execute the DELETE
            $statement->execute();
            
            // Redirect after update to the product page.
            header("Location: products.php");
		}

		if(empty($_POST['category_name']) && isset($_POST['id']) && isset($_POST['update']))
    	{
	        //Redirects user to error message page.
	        header("Location:error.php");
	        exit;
    	}
	}
	
?>



