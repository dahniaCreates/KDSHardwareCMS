<!--

    Final Project
    Name: Dahnia Simon
    Created on: November 7, 2021
    Updated on: November 7, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<?php  

    if ($_POST && !empty($_POST['productName']) && !empty($_POST['price']) && isset($_POST['categoryId'])){
        require('connect.php');


        $productname = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $categoryid = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
        

        $query = "INSERT INTO products(productName, price, categoryId) VALUES (:productname, :price, :categoryId)"; 
        $statement = $db->prepare($query);


        $statement->bindValue(":productname", $productname);
        $statement->bindValue(":price", $price);
        $statement->bindValue(":categoryId", $categoryid);

        //Executes the INSERT query.
        $statement->execute();


        header("Location: products.php");
        exit;
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