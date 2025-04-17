<?php

include('server/connection.php');

session_start();


if( !empty($_SESSION['cart']) && isset($_POST['checkout']) ){

    //let user in



    //send user to home page
}else{

    header('location: index.php');
}




?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/262086238a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<!--Checkout-->

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Checkout</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form id="checkout-form">

            <div class="form-group checkout-small-element">
                <label>Name</label>
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required/>
            </div>

            <div class="form-group checkout-small-element">
                <label>Email</label>
                <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" required/>
            </div>

            <div class="form-group checkout-small-element">
                <label>Phone</label>
                <input type="number" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required/>
            </div>

            <div class="form-group checkout-large-element">
                <label>City</label>
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required/>
            </div>

            <div class="form-group checkout-large-element">
                <label>Address</label>
                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required/>
            </div>

            <div class="form-group checkout-btn-element">
                <p>Total Amount: RM<?php echo $_SESSION['total_cost']; ?></p>
                <input type="submit" class="btn" id="checkout-btn" value="Checkout"/>
            </div>

        </form>
    </div>
    
</section>



<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<style>

/*Checkout*/

#checkout-form .checkout-small-element{
    display: inline-block;
    width: 48%;
    margin: 10px auto;
}

#checkout-form .checkout-large-element{
    width: 95%;
}

#checkout-form .checkout-btn-container{
    margin: 10px;
    text-align: right;
    margin-right: 40px;
}

#checkout-form #checkout-btn{
    color: white;
    background-color: black;
}

</style>

