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

  $query = "SELECT * FROM categories";
  $statement = $db->prepare($query);

  //Executes the SELECT query.
  $statement->execute(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>KDS Hardware Store</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
      <form method="post" action="processnewproductinsert.php" enctype='multipart/form-data'>
          <fieldset>
            <legend>Create New Product</legend>
              <p>
                <label for="productName">Product Name</label>
                <input name="productName" id="productName" />
              </p>
               <p>
                <label for="price">Price</label>
                <input name="price" id="price" />
              </p>
              <p>
                <label for='uploadedfile'>Image filename:</label>
                <input type='file' name='uploadedfile' id='uploadedfile'>
              </p>
              <label for="categoryId">Product Category:</label>
              <select id="categoryId" name="categoryId">
                  <?php while($row = $statement->fetch()): ?>
                    <option value="<?=$row['id']?>"><?= $row['category_name'] ?></option>
                  <?php endwhile ?>
              </select>
              <p>
                <input type="submit" value="Create" />
              </p>
          </fieldset>
       </form>
      </div>
</body>
</html>