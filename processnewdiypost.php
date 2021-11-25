<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 25, 2021
    Updated on: November 25, 2021
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

        if ($_POST && !empty($_POST['title']) && !empty($_POST['description']) && $valid_upload_detected){
                  require('connect.php');

                $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $customerid = filter_input(INPUT_GET, 'customerid', FILTER_SANITIZE_NUMBER_INT);

                $file_filename        = $_FILES['uploadedfile']['name'];
                $temporary_image_path = $_FILES['uploadedfile']['tmp_name'];
                $new_file_path        = file_upload_path($file_filename);
                if (file_is_valid($temporary_image_path, $new_file_path)) {                        
                        $image = new \Gumlet\ImageResize($_FILES['uploadedfile']['name']);
                        $image->resize(650, 650);
                        $image_filename_edited = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_FILENAME). "_categorythumbnail." . pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
                        $image->save('images/'.$image_filename_edited);
        
                        $query = "INSERT INTO diys(title, description, image, customerid) VALUES (:title, :description, :image, :customerid)"; 
                        $statement = $db->prepare($query);

                        $statement->bindValue(":title", $title);
                        $statement->bindValue(":description", $description);
                        $statement->bindValue(":image", $image_filename_edited);  
                        $statement->bindValue(":customerid", $customerid);

                        $statement->execute();

                         header("Location: mydiys.php?customerid=$customerid");
                        exit;
               }
      }
      else if($_POST && !empty($_POST['title']) && !empty($_POST['description']) && $optional_upload)
      {
         require('connect.php');
         $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $customerid = filter_input(INPUT_GET, 'customerid', FILTER_SANITIZE_NUMBER_INT);

         $querytwo = "INSERT INTO diys(title, description, customerid) VALUES (:title, :description, :customerid)";
         $statement = $db->prepare($querytwo);
         
         $statement->bindValue(":title", $title);
         $statement->bindValue(":description", $description);
         $statement->bindValue(":customerid", $customerid);   
                     
         $statement->execute();
         header("Location: mydiys.php?customerid=$customerid");
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
            The title and description must contain at least one character.
         </p>
         <a href="mydiys.php?customerid=<?=$_GET['customerid']?>">Return My DIYs</a>
      </div>
   </body>
</html>