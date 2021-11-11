<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: November 7, 2021
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

    if ($_POST && !empty($_POST['productName']) && !empty($_POST['price']) && isset($_POST['categoryId']) && $valid_upload_detected){
        require('connect.php');

        $productname = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $categoryid = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
        $file_filename        = $_FILES['uploadedfile']['name'];
        $temporary_image_path  = $_FILES['uploadedfile']['tmp_name'];
        $new_file_path        = file_upload_path($file_filename);
            if (file_is_valid($temporary_image_path, $new_file_path)) {
                if(move_uploaded_file($temporary_image_path, $new_file_path)){
                        
                    $image = new \Gumlet\ImageResize($_FILES['uploadedfile']['name']);
                    $image->resize(300, 300);
                    $image_filename_edited = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_FILENAME). "_categorythumbnail." . pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
                     $image->save('images/'.$image_filename_edited);     

                    $query = "INSERT INTO products(productName, price, categoryId, images) VALUES (:productname, :price, :categoryId, :images)"; 
                    $statement = $db->prepare($query);

                    $statement->bindValue(":productname", $productname);
                    $statement->bindValue(":price", $price);
                    $statement->bindValue(":categoryId", $categoryid);
                    $statement->bindValue(":images", $image_filename_edited);  

                    //Executes the INSERT query.
                    $statement->execute();

                    header("Location: products.php");
                    exit;
                }
            }
    }
    else{
        //Sets an error message to be displayed if the user enters invalid enteries.
        $error_message = "An error occured while processing your post.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>Dahnia's Blog - Error</title>
</head>
<body>
    <div id = "wrapper">
        <h2><?="{$error_message}"?></h2>
        <p>
            All form elements must contain a value.
        </p>
        <a href="newcategory.php">Return Home</a>
    <div id="footer">
        Copywrong 2021 - No Rights Reserved
    </div> <!-- END of div with id="footer" -->
    </div>
</body>
</html>