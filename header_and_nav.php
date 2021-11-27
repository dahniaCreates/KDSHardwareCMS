<!--
    Final Project
    Name: Dahnia Simon
    Created on: November 24, 2021
    Updated on: November 24, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<title>KDS Hardware Store</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
            <h1>KDS Hardware Store</h1>
               <div class="mr-5">
            <?php if(isset($_SESSION['user'])): ?>            
            <?='Welcome back, ' . $_SESSION['user']?>
            <?php endif?>
            <a class="btn btn-dark" href="register.php" role="button" 
               <?php if(isset($_SESSION['user'])): ?> style="display:none;" 
               <?php endif?>>Register
            </a>
            <a class="btn btn-dark" href="login.php" role="button" 
               <?php if(isset($_SESSION['user'])): ?> style="display:none;" 
               <?php endif?>>Login
            </a>
            <?php if(isset($_SESSION['user'])): ?>   
            <a class="btn btn-dark" href="logout.php" role="button" >Logout</a>
            <?php endif?>
             </div>
            </div>
         </div>
      </nav>

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
            <a class="navbar-brand" href="/wd2/finalProject/home">KDS Hardware</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="/wd2/finalProject/home">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/wd2/finalProject/products">Products</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="aboutus.php">About Us</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="alldiys.php">Customers DIYs</a>
                  </li>
                   <?php if(isset($_SESSION['user']) && $_SESSION['role'] == "customer"): ?>   
                  <li class="nav-item">
                     <a class="nav-link" href="mydiys.php?customerid=<?=$customerid?>">My DIYs</a>
                  </li>
               <?php endif?>
               </ul>
               <form class="d-flex" action="/wd2/finalProject/searchresult" method="post" enctype="multipart/form-data">
                  <input class="form-control me-2" type="search" placeholder="Search" name="searchword" value="" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
               </form>
            </div>
         </div>
      </nav>