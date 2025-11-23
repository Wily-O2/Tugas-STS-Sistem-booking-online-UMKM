<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toura</title>
  <link rel="stylesheet" href="/Project STS/home1/Main.css">
  <link rel="stylesheet" href="/Project STS/user.css">
  <link rel="stylesheet" href="Product.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="Head">
  <header>
    <nav>
      <a href="../Main.php">Home</a>
      <a href="Product.php">Product</a>
      <a href="../About/about.php">About</a>
      <a href="../feature/feature.php">Features</a>
      <a href="../pricing/pricing.php">Pricing</a>
    </nav>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="user-menu">
        <i class="bx bx-user user-icon"></i>
        <div class="dropdown-menu">
          <table>
            <tr><td><a href="../user.php">Profile</a></td></tr>
            <tr><td><a href="../user.php#settings">Settings</a></td></tr>
            <tr><td><a href="../login/logout.php">Logout</a></td></tr>
          </table>
        </div>
      </div>
    <?php else: ?>
      <button class="btn btn-blue"><a href="../login/login.php">Login</a></button>
    <?php endif; ?>
  </header>
</div>

<section class="Produk">
    <Div class="Judul"> 
        <h1>Search For you Bussiness</h1>
    </Div>

    <div class="search-container">
         <input type="text" class="search-box" placeholder="Search...">
    </div>

    <div class="set-up">
        Set Up Your Digital Platform
    </div>

   <div class="box-digital">
     <div class="box">
      <p>Eddy’s - Coffee & Eatery</p>
     </div>
  <div class="box">
    <p>Amy’s - Bakery</p>
  </div>
  <div class="box">
    <p>John Pork’s - Butchery</p>
  </div>
  <div class="box">
    <p>Matsuro’s - Florist</p>
  </div>
   </div>

   <div class="gambar"></div>

   <!-- <div class="vertical-lines"></div> -->

   <div id="Book">
    <h1>Book Your Place</h1>
   </div>

   <div class="Box-Book">
    <div class="Box">
      <p>Eddy’s - Coffee & Eatery</p>
    </div>
    <div class="Box">
      <p>Amy’s - Bakery</p>
    </div>
    <div class="Box">
      <p>John Pork’s - Butchery</p>
    </div>
    <div class="Box">
      <p>Matsuro’s - Florist</p>
    </div>
    <div class="Box">
      <p>Eddy’s - Coffee & Eatery</p>
    </div>
    <div class="Box">
      <p>Amy’s - Bakery</p>
    </div>
    <div class="Box">
      <p>John Pork’s - Butchery</p>
    </div>
    <div class="Box">
      <p>Matsuro’s - Florist</p>
    </div>
   </div>

   <div id="Place"><h1>Place For An Meeting</h1></div>

    <div class="place-Meeting">
    <div class="BoxPlace">
      <p>Eddy’s - Coffee & Eatery</p>
    </div>
    <div class="BoxPlace">
      <p>Amy’s - Bakery</p>
    </div>
    <div class="BoxPlace">
      <p>John Pork’s - Butchery</p>
    </div>
    <div class="BoxPlace">
      <p>Matsuro’s - Florist</p>
    </div>
   </div>
   
   <div class="About-us">.</div>

   
</section>