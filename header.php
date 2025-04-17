<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZYZA Ismail Boutique</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>

     <!-- Navbar -->
   <nav class="navbar fixed-top">
    <div class="container">
        <!-- Left: Search Box -->
        <div class="search-box">
            <input type="text" placeholder="Search">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>

        <!-- Center: Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="assets/zyza_logo.png" alt="ZYZA">
        </a>

        <!-- Right: Navigation Icons -->
        <div class="nav-icons">
            <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="account.php"><i class="far fa-user"></i></a>
        </div>
    </div>

    <div class="nav-divider"></div>

    <hr class="custom-line">

    <!-- Page Links -->
    <div class="nav-links">
        <a href="shop.php">BEST SELLING</a>
        <a href="shop.php">NEW ARRIVAL</a>
        <div class="dropdown">
            <a href="shop.php" class="dropdown-toggle" data-toggle="dropdown">SHOP </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="shop.php?category=1">Baju Kurung</a>
                <a class="dropdown-item" href="shop.php?category=2">Blouse</a>
                <a class="dropdown-item" href="shop.php?category=3">Pants</a>
                <a class="dropdown-item" href="shop.php?category=4">Skirts</a>
            </div>
        </div>
        <a href="contact.php">CONTACT US</a>
    </div>
</nav>

</header>

<!-- Add spacer for fixed navbar -->
<div class="navbar-spacer"></div>

<style>

@font-face {
    font-family: 'Glacial Indifference';
    src: url('assets/GlacialIndifference-Regular.otf') format('opentype');
    font-weight: normal;
}

@font-face {
    font-family: 'Glacial Indifference';
    src: url('assets/GlacialIndifference-Bold.otf') format('opentype');
    font-weight: bold;
}

* {
    font-family: 'Glacial Indifference', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Navbar Styling */
.navbar {
    background-color: white;
    padding: 15px 0;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.container {
    width: 90%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Search Box */
.search-box {
    position: relative;
}

.search-box input {
    padding: 8px 15px 8px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    width: 200px;
    font-size: 14px;
    background-color: #f5f5f5;
}

.search-box button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    color: #666;
    cursor: pointer;
}

hr.custom-line {
    border: 1px solid black;  /* Remove default border */
    height: 1px;   /* Set thickness */
    color: black;
    display: block; /* Ensure it's visible */
    width: 100%;
    margin-top: 3px;
    margin-bottom: 3px;
}


/* Logo */
.navbar-brand img {
    height: 70px;
    margin-left: -70px;
    width: auto;
}

/* Navigation Icons */
.nav-icons {
    display: flex;
    gap: 25px;
}

.nav-icons a {
    color: #333;
    text-decoration: none;
}

.nav-icons i {
    font-size: 18px;
    transition: color 0.3s ease;
}

.nav-icons i:hover {
    color: #666;
}

/* Page Links */
.nav-links {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 10px;
    margin-left: 60px;
    font-size: 14px;
    font-weight: bold;
}

.nav-links a {
    text-decoration: none;
    color: #333;
}

.nav-links a:hover {
    color: #666;
}

.dropdown-menu{
    display: none;
}

.dropdown-toggle:focus + .dropdown-menu{
    display: block !important;
    radius: 0px;
}

/* Add navbar spacer styles */
.navbar-spacer {
    height: 180px; /* Adjust this value based on your navbar height */
}

@media (max-width: 768px) {
    .navbar-spacer {
        height: 200px; /* Slightly more space on mobile */
    }
}

</style>