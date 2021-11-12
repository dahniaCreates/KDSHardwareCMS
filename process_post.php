<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 5, 2021
    Updated on: November 11, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
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
	        if (!empty($_POST['category_name']) && isset($_POST['id']) && $valid_upload_detected) {
	            $categoryname  = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

			            $query     = "UPDATE categories SET category_name = :categoryname, images = :images WHERE id = :id LIMIT 1";
			            $statement = $db->prepare($query);
			            $statement->bindValue(':categoryname', $categoryname);
			            $statement->bindValue(":images", $image_filename_edited);        
			            $statement->bindValue(':id', $id, PDO::PARAM_INT);
			            
			            $statement->execute();
			            
			            header("Location: products.php");
			            exit;
	        		}

	    		}

	        }
	        else
	        {
	        	$error_message = "An error occured while processing your update.";
	        }
		}
		else if($_POST['command'] == 'Delete')
		{
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            require('connect.php');

            $query = "DELETE FROM categories WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);

            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            
            $statement->execute();
            
            header("Location: index.php");
		}
	}	
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>KDS Hardware Store - Update Category Error</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css">      
        <h1>KDS Hardware Store</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
            <a class="navbar-brand" href="index.php">KDS Hardware</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="products.php">Products</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="aboutus.php">About Us</a>
                  </li>
               </ul>
               <form class="d-flex">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
               </form>
            </div>
         </div>
      </nav>
   </head>
   <body>
      <div>
         <h2><?="{$error_message}"?></h2>
         <p>
         	An image file must be uploaded and the category name must contain at least one character.
         </p>
         <a href="products.php">Return to Products</a>
      </div>
      <footer class="fixed-bottom">
         <div class="conatiner" style="padding-top:80px; background-color:grey; margin-top:20px;">
            <div class="row">
               <div class="col" style="text-align: center;">
                  COMPANY
                  <div>
                     <a href="aboutus.php">About Us</a>
                  </div>
               </div>
               <div class="col" style="text-align: center;">
                  CONTACT
                  <p>kdshardware2020@gmail.com</p>
                  <p>+204 453 6175</p>
               </div>
               <div class="col" style="text-align: center;">
                  ADDRESS
                  <p>
                     109 Princess Street</br>
                     Winnipeg MB</br>
                     R4B 1EX
                  </p>
               </div>
            </div>
         </div>
      </footer>
   </body>
</html>


