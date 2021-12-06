<!--
    Final Project
    Name: Dahnia Simon
    Created on: November 24, 2021
    Updated on: December 05, 2021
    Course: WEBD-2008 (213758) Web Development 2
-->
<title>KDS Hardware Store</title>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link rel="stylesheet" href="/wd2/finalProject/styles.css">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
            <h1>KDS Hardware Store</h1>
               <div class="mr-5">
            <?php if(isset($_SESSION['user'])): ?>            
            <?='Welcome back, ' . $_SESSION['user']?>
            <?php endif?>
            <a class="btn btn-dark" href="/wd2/finalProject/register" role="button" 
               <?php if(isset($_SESSION['user'])): ?> style="display:none;" 
               <?php endif?>>Register
            </a>
            <a class="btn btn-dark" href="/wd2/finalProject/login" role="button" 
               <?php if(isset($_SESSION['user'])): ?> style="display:none;" 
               <?php endif?>>Login
            </a>
            <?php if(isset($_SESSION['user'])): ?>   
            <a class="btn btn-dark" href="wd2/finalProject/logout" role="button" >Logout</a>
            <?php endif?>
             </div>
            </div>
         </div>
      </nav>

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid">
            <a class="navbar-brand" href="/wd2/finalProject/home">KDS Hardware</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                     <a class="nav-link" aria-current="page" href="/wd2/finalProject/home">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/wd2/finalProject/products">Products</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/wd2/finalProject/aboutus">About Us</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/wd2/finalProject/customerdiys">Customers DIYs</a>
                  </li>
                   <?php if(isset($_SESSION['user']) && $_SESSION['role'] == "customer"): ?>   
                  <li class="nav-item">
                     <a class="nav-link" href="/wd2/finalProject/mydiys/<?=$customerid?>">My DIYs</a>
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