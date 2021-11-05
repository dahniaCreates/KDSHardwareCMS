<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 4, 2021
    Updated on: November 4, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
    //Connection to the database
    require('connect.php');

    //Call to the script that ensures that the edit page is username and password protected.
    require 'authenticate.php';

    //Check if all conditions are met to perform an update can occur.
    if ($_POST && !empty($_POST['category_name']) && isset($_POST['id']) && isset($_POST['update'])) {
        // Sanitization of user input to filter out malicious characters.
        $categoryname  = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        
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
    else if (isset($_GET['id'])){// Retrieve the post to be edited based on the id value in the URL.
        // Sanitize the id retrived from the URL using GET.
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                    
        /* Build the parametrized SQL query using the filtered id value and 
        binding the placeholder to the filtered id value.*/
        $query = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $statement = $db->prepare($query);
        //Specifies the $id binding-type to be Integer. 
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
                    
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $post = $statement->fetch();

        //Check to ensure that the id value set in the URL returns a record from the database
        if($statement->rowCount() == 0){
        header("Location: products.php");//Redirects the user to the index page if invalid id number is set in URL.
        exit;
        }
    }
    else{
        $id = false; // Sets id to false if we are not UPDATING or SELECTING.
    }
    if(isset($_POST['delete']) && isset($_GET['id']){//Check if all conditions are met for delete.
        //Retrives the id value in the URL and sanitizes it.
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        //Builds and prepares the parameterized SQL query to delete the specified record based on the id value.
        $query = "DELETE FROM categories WHERE id = :id LIMIT 1";
        $statement = $db->prepare($query);
        //Binds the placeholder :id value to the filtered id value and specifies the binding type as Integer.
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        // Execute the DELETE
        $statement->execute();
        
        // Redirect after update to the index page.
        header("Location: index.php");
        exit;
    }

    //Checks if the title and content fields contains at least one character to update.
    if($_POST && empty($_POST['category_name']) && isset($_POST['id']) && isset($_POST['update']))
    {
        //Redirects user to error message page.
        header("Location:error.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KDS Hardware Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <h1>KDS Hardware Store</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">KDS Hardware</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
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
    <?php if($id): ?>
            <form method="post">
                <fieldset>
                    <legend>Update or Delete Category</legend>
                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                    <p>
                        <label for="category_name">Category Name</label>
                        <input name="category_name" id="category_name" value="<?= $post['category_name'] ?>">
                    </p>
                    <p>
                        <input type="submit" name="update" value="Update" />
                        <!-- Delete button with javascript confirm message box to confirm delete.-->
                        <input type="submit" name="delete" value="Delete" onclick= "confirm('Are you sure you wish to delete this category?')" />
                    </p>
                </fieldset>
            </form>
        <?php endif?>
 <footer>
    <div class="conatiner" style="padding-top:80px; background-color:grey; margin-top:20px;">
    <div class="row">
    <div class="col" style="text-align: center;">
      COMPANY
        <div>
            <a href="#">About Us</a>
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

