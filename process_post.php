<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 5, 2021
    Updated on: November 5, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
	require('authenticate.php');


	if($_POST)
	{
		if($_POST['command'] == 'Update')
		{
			
	        if (!empty($_POST['category_name']) && isset($_POST['id'])) {
	            // Sanitization of user input to filter out malicious characters.
	            $categoryname  = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	            $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
	            
	            require('connect.php');
	            // Build the parameterized SQL query and bind to the above sanitized values.
	            $query     = "UPDATE categories SET category_name = :categoryname WHERE id = :id LIMIT 1";
	            $statement = $db->prepare($query);
	            $statement->bindValue(':categoryname', $categoryname);        
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
            $query = "DELETE FROM categories WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);
            //Binds the placeholder :id value to the filtered id value and specifies the binding type as Integer.
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            
            // Execute the DELETE
            $statement->execute();
            
            // Redirect after update to the product page.
            header("Location: index.php");
		}

		if(empty($_POST['category_name']) && isset($_POST['id']) && isset($_POST['update']))
    	{
	        //Redirects user to error message page.
	        header("Location:error.php");
	        exit;
    	}
	}
	
?>



