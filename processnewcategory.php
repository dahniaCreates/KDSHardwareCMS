<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 6, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php 
session_start();
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

        if ($_POST && !empty($_POST['category_name']) && $valid_upload_detected){
        require('connect.php');

                $categoryname = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $file_filename        = $_FILES['uploadedfile']['name'];
                $temporary_image_path  = $_FILES['uploadedfile']['tmp_name'];
                $new_file_path        = file_upload_path($file_filename);
                if (file_is_valid($temporary_image_path, $new_file_path)) {                        
                        $image = new \Gumlet\ImageResize($_FILES['uploadedfile']['name']);
                        $image->resize(300, 300);
                        $image_filename_edited = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_FILENAME). "_categorythumbnail." . pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
                        $image->save('images/'.$image_filename_edited);
        
                        $query = "INSERT INTO categories(category_name, images) VALUES (:categoryname, :images)"; 
                        $statement = $db->prepare($query);

                        $statement->bindValue(":categoryname", $categoryname);
                        $statement->bindValue(":images", $image_filename_edited);  

                        $statement->execute();

                        header("Location: newproductinsert.php");
                        exit;
               }
      }
      else if(!empty($_POST['category_name']) && $optional_upload)
      {
         $categorynameupload  = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         require('connect.php');
         $querytwo = "INSERT INTO categories(category_name) VALUES (:categorynm)";
               $statement = $db->prepare($querytwo);
               $statement->bindValue(':categorynm', $categorynameupload);   
                     
               $statement->execute();
               header("Location: products.php");
               exit;
     }
     else{
        $error_message = "An error occured while processing your new category insert.";
    }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
       <?php include('header_and_nav.php')?>
   </head>
   <body>
      <div>
         <h2><?="{$error_message}"?></h2>
         <p>
            The category name must contain at least one character.
         </p>
         <a href="products.php">Return to Products</a>
      </div>
   </body>
</html>