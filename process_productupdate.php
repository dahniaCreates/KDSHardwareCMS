<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: November 7, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
	require('authenticate.php');
	require('\xampp\htdocs\a\php-image-resize-master\lib\ImageResize.php');
    require('\xampp\htdocs\a\php-image-resize-master\lib\ImageResizeException.php');

    	function file_upload_path($original_filename, $upload_subfolder_name = 'images') {
	       $current_folder = dirname(__FILE__);

	       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];     
	 
	       return join(DIRECTORY_SEPARATOR, $path_segments);
	    }

	    function file_is_valid($temporary_path, $new_path) {
	        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
	        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
	        
	        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
	        $actual_mime_type        = mime_content_type($_FILES['uploadedfile']['name']);
	        
	        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
	        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

	        return $file_extension_is_valid && $mime_type_is_valid;
	    }
	    
	    $valid_upload_detected = isset($_FILES['uploadedfile']) && ($_FILES['uploadedfile']['error'] === 0);
	    $upload_error_detected = isset($_FILES['uploadedfile']) && ($_FILES['uploadedfile']['error'] > 0);

	if($_POST)
	{
		if($_POST['command'] == 'Update')
		{
			
	        if (!empty($_POST['productName']) && !empty($_POST['price']) && !empty($_POST['categoryId']) && isset($_POST['id']) 
	        	&& $valid_upload_detected) {
	            // Sanitization of user input to filter out malicious characters.
	            $productname  = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	            $categoryid = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
	            $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

	            $file_filename        = $_FILES['uploadedfile']['name'];
	        	$temporary_image_path  = $_FILES['uploadedfile']['tmp_name'];
	         	$new_file_path        = file_upload_path($file_filename);
	         	if (file_is_valid($temporary_image_path, $new_file_path)) {
	            	if(move_uploaded_file($temporary_image_path, $new_file_path)){          
				            
			            require('connect.php');

			           	$image = new \Gumlet\ImageResize($_FILES['uploadedfile']['name']);
	        			$image->resize(300, 300);
	        			$image_filename_edited = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_FILENAME). "_categorythumbnail." . pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
	            		$image->save('images/'.$image_filename_edited);
			            // Build the parameterized SQL query and bind to the above sanitized values.
			            $query     = "UPDATE products SET productName = :productName, price = :price, categoryId = :categoryId
			            			, images = :images WHERE id = :id LIMIT 1";
			            $statement = $db->prepare($query);
			            $statement->bindValue(':productName', $productname);
			            $statement->bindValue(':price', $price);
			            $statement->bindValue(':categoryId', $categoryid);   
			            $statement->bindValue(":images", $image_filename_edited);         
			            $statement->bindValue(':id', $id, PDO::PARAM_INT);
			            
			            // Execute the INSERT.
			            $statement->execute();
			            
			            // Redirect to index page after update ans exit script.
			            header("Location: products.php");
			            exit;
			        }
			    }
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



