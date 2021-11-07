<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 6, 2021
    Updated on: November 6, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php
  //Call to the script that ensures that the create page is username and password protected.
  require ('authenticate.php');
   require('connect.php');

  // $query = "SELECT * FROM categories WHERE categoryId = :categoryId";
  // $statement = $db->prepare($query);

  // //Executes the SELECT query.
  // $statement->execute(); 

  if (isset($_GET['categoryId'])) {
      // Build and prepare SQL String with :id placeholder parameter.
      $query = "SELECT * FROM categories WHERE id = :categoryId";
      $statement = $db->prepare($query);

      
      // Sanitize $_GET['id'] to ensure it's an integer.
      $categoryid = filter_input(INPUT_GET, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
      
      // Bind the :id parameter in the query to the sanitized
      // $id specifying a binding-type of Integer.
      $statement->bindValue('categoryId', $categoryid, PDO::PARAM_INT);
      $statement->execute();
      
      // Fetch the row selected by primary key id.
      $row = $statement->fetch();

      //Fetches the timestamp value for the selected row and fromats it to a string and then using the data function.
      $categoryId = $row['id'];
      $categoryName = $row['category_name']; 

      //Ensures that the id specified in the GET returns at least one row.
      if($statement->rowCount() == 0){
        //Redirects the user to the index page if the id value is invalid.
        header("Location: index.php");
        exit;
      }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>KDS Hardware Store</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
      <form method="post" action="processnewproduct.php">
          <fieldset>
            <legend>Create New Product for <?=$categoryName?></legend>
              <p>
                <label for="productName">Product Name</label>
                <input name="productName" id="productName" />
              </p>
               <p>
                <label for="price">Price</label>
                <input name="price" id="price" />
              </p>
              <input type="hidden" name="categoryId" id="categoryId" value="<?=$categoryId?>" readonly/>
              <p>
                <input type="submit" value="Create" />
              </p>
          </fieldset>
       </form>
      </div>
</body>
</html>