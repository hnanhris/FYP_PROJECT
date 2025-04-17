<?php

session_start();

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


<!--Payment-->

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <p><?php echo $_GET['order_status']; ?></p>
        <p>Total payment: $<?php echo $_SESSION['total']; ?></p>
        <input class="btn btn-primary" type="submit" value="Pay Now"/>
        

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