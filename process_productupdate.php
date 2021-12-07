<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: December 05, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
	session_start();

   if(isset($_SESSION['user']))
   {
   	require('connect.php');
      $query = "SELECT * FROM users WHERE username = :username";
      $username = $_SESSION['user'];
      $statement = $db->prepare($query);

      $statement->bindValue(':username', $username);
      $statement->execute(); 

      $row= $statement->fetch();
      $customerid = $row['customerid'];
   }
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
	    $optional_upload = ($_FILES['uploadedfile']['error'] === 4);

	if($_POST)
	{
		if($_POST['command'] == 'Update')
		{			
	        if (!empty($_POST['productName']) && !empty($_POST['price']) && !empty($_POST['categoryId']) && isset($_POST['id']) 
	        	&& $valid_upload_detected) {

	            $productname  = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	            $categoryid = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
	            $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

	            $file_filename        = $_FILES['uploadedfile']['name'];
	        	   $temporary_image_path  = $_FILES['uploadedfile']['tmp_name'];
	         	$new_file_path        = file_upload_path($file_filename);
	         	if (file_is_valid($temporary_image_path, $new_file_path)) {        
				            
			            require('connect.php');

			         $image = new \Gumlet\ImageResize($_FILES['uploadedfile']['name']);
	        			$image->resize(300, 300);
	        			$image_filename_edited = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_FILENAME). "_categorythumbnail." . pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
	            		$image->save('images/'.$image_filename_edited);

			            $query     = "UPDATE products SET productName = :productName, price = :price, categoryId = :categoryId
			            			, images = :images WHERE id = :id LIMIT 1";
			            $statement = $db->prepare($query);
			            $statement->bindValue(':productName', $productname);
			            $statement->bindValue(':price', $price);
			            $statement->bindValue(':categoryId', $categoryid);   
			            $statement->bindValue(":images", $image_filename_edited);         
			            $statement->bindValue(':id', $id, PDO::PARAM_INT);

			            $statement->execute();

			            header("Location: /wd2/finalProject/products");
			            exit;
			      }
	         }
	        else if(!empty($_POST['productName']) && !empty($_POST['price']) && !empty($_POST['categoryId']) && isset($_POST['id']) && $optional_upload)
           {
               $productname  = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	            $categoryid = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
               $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
               require('connect.php');
               $querytwo = "UPDATE products SET productName = :productnm,  price = :productprice, categoryId = :categoryid WHERE id = :id LIMIT 1";
                     $statement = $db->prepare($querytwo);
                     $statement->bindValue(':productnm', $productname);
			            $statement->bindValue(':productprice', $price);
			            $statement->bindValue(':categoryid', $categoryid);   
                     $statement->bindValue(':id', $id, PDO::PARAM_INT);
                     
                     $statement->execute();
               header("Location: /wd2/finalProject/products");
               exit;
           }
	        else
	        {
	        	$error_message = "An error occured while processing your update for the product.";
	        }
		}	
		else if($_POST['command'] == 'Delete')
		{
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            require('connect.php');

            $query = "DELETE FROM products WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);

            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            $statement->execute();
            
            header("Location: /wd2/finalProject/products");
            exit;
		}
	}	
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
     <?php include('subpage_nav.php')?>
   </head>
   <body>
      <div>
         <h2><?="{$error_message}"?></h2>
         <p>
         	The product name and price must contain at least one character.
         </p>
         <a href="/wd2/finalProject/products">Return to Products</a>
      </div>
   </body>
</html>



