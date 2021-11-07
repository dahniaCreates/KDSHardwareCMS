<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 6, 2021
    Updated on: November 6, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
  //Call to the script that ensures that the create page is username and password protected.
  require 'authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>KDS Hardware Store</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
      <form method="post" action="processnewcategory.php">
          <fieldset>
            <legend>Create New Product Category</legend>
              <p>
                <label for="category_name">Category Name</label>
                <input name="category_name" id="category_name" />
              </p>
              <p>
                <input type="submit" value="Create" />
              </p>
          </fieldset>
       </form>
      </div>
</body>
</html>