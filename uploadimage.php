<!--
    Final Project
    Name: Dahnia Simon
    Created on: November 8, 2021
    Updated on: November 8, 2021
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

    if ($valid_upload_detected) { 
        $file_filename        = $_FILES['uploadedfile']['name'];
        $temporary_image_path  = $_FILES['uploadedfile']['tmp_name'];
        $new_file_path        = file_upload_path($file_filename);
        if (file_is_valid($temporary_image_path, $new_file_path)) {
            if(move_uploaded_file($temporary_image_path, $new_file_path)){
                $id  = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                
                require('connect.php');

                 $query = "INSERT INTO categories(images) VALUES (:images) WHERE id = :id"; 
                    $statement = $db->prepare($query);

                    //Binds the :title and :content paramenters to the sanitized variables of $title and $content.
                    $statement->bindValue(":images", $file_filename);
                    $statement->bindValue(':id', $id, PDO::PARAM_INT);

                    //Executes the INSERT query.
                    $statement->execute();

                    //Redirects the user to the index page and exits the script.
                    header("Location: products.php");
                    exit;
            }
        }
        $image = new \Gumlet\ImageResize($_FILES['uploadedfile']['name']);
        $image->resizeToWidth(400);
        $image_filename_edited = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_FILENAME). "_categorythumbnail." . pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
            $image->save('images/'.$image_filename_edited);
    }
?>
 <!DOCTYPE html>
 <html>
     <head><title>Image upload</title></head>
 <body>
    <h3>Upload an image to add to the category</h3>
     <form method='post' enctype='multipart/form-data'>
         <label for='uploadedfile'>Image filename:</label>
         <input type='file' name='uploadedfile' id='uploadedfile'>
         <input type='submit' name='submit' value='Upload Image'>
     </form>
     
    <?php if ($upload_error_detected): ?>

        <p>Error Number: <?= $_FILES['uploadedfile']['error'] ?></p>

    <?php elseif ($valid_upload_detected): ?>

    <p>Image upload successful!</p>
      <!--   <p>Client-Side Filename: <?= $_FILES['uploadedfile']['name'] ?></p>
        <p>Apparent Mime Type:   <?= $_FILES['uploadedfile']['type'] ?></p>
        <p>Size in Bytes:        <?= $_FILES['uploadedfile']['size'] ?></p>
        <p>Temporary Path:       <?= $_FILES['uploadedfile']['tmp_name'] ?></p>
 -->
    <?php endif ?>
 </body>
 </html>