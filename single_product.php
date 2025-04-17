
<?php

include('server/connection.php');


if(isset($_GET['product_id'])){

    $product_id = $_GET['product_id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);

$stmt->execute();

    $product = $stmt->get_result();//[]



//no product id was given
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
    <title>Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/262086238a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>


<!--Single Product-->
<section class="container single-product my5 pt-5">
    <div class="row mt-5">

    <?php while ($row = $product->fetch_assoc()) { ?>

        <div class="col-lg-5 col-md-6 col-sm-12">
            <img class="img-fluid w-100 pb-1" src="assets/<?php echo $row['product_image']; ?>" id="mainImg">
            <div class="smaill-img-group">

                <div class="small-img-col">
                    <img src="assets/<?php echo $row['product_image']; ?>" width="100%" class="small-img">
                </div>

                <div class="small-img-col">
                    <img src="assets/<?php echo $row['product_image2']; ?>" width="100%" class="small-img">
                </div>

                <div class="small-img-col">
                    <img src="assets/<?php echo $row['product_image3']; ?>" width="100%" class="small-img">
                </div>

                <div class="small-img-col">
                    <img src="assets/<?php echo $row['product_image4']; ?>" width="100%" class="small-img">
                </div>
                
            </div>
        </div>

        <div class="col-lg-6 col-md-2 col-12">
            <h6>Home / T-Shirt / Mikayla</h6>
            <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
            <h2>RM <?php echo $row['product_price']; ?></h2>
            <input type="number" value="1"/>
            <button class="buy-btn">Add to Cart</button>
            <h4 class="mt-5 mb-5">Product Details</h4>
            <span><?php echo $row['product_description']; ?></span>
        </div>

    <?php } ?>

    </div>
</section>


<!--Related products-->
<section id="related-products" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Pallazo Pants</h3>
          <hr class="mx-auto">
        </div>

        <div class="row mx-auto container-fluid">

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3"src="assets/pallazo-featured.webp"/>

            <h5 class="p-name">Pallazo</h5>
            <h4 class="p-price">RM 49.90</h4>
            <button class="buy-btn">Buy Now</button>
          </div>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3"src="assets/pallazo-featured.webp"/>

            <h5 class="p-name">Pallazo</h5>
            <h4 class="p-price">RM 49.90</h4>
            <button class="buy-btn">Buy Now</button>
          </div>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3"src="assets/pallazo-featured.webp"/>

            <h5 class="p-name">Pallazo</h5>
            <h4 class="p-price">RM 49.90</h4>
            <button class="buy-btn">Buy Now</button>
          </div>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3"src="assets/pallazo-featured.webp"/>

            <h5 class="p-name">Pallazo</h5>
            <h4 class="p-price">RM 49.90</h4>
            <button class="buy-btn">Buy Now</button>
          </div>

        </div>
      </section>










      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
      <script>

        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");


        for(let i=0; i<4; i++){
            smallImg[i].onclick = function () {
                mainImg.src = smallImg[i].src;
            }
        }

      </script>
</body>
</html>



<style>

.container .single-product{
    margin-top: 300px;
}

    .smaill-img-group{
        display: flex;
        justify-content: space-between;
    }

    .small-img-col{
        flex-basis: 24%;
        cursor: pointer;
    }

    .single-product input{
        width: 50px;
        height: 35px;
        padding-left: 10px;
        font-size: 16px;
        margin-right: 10px;
    }

    .single-product input:focus{
        outline: none;
    }

    .single-product .buy-btn{
        background-color: black;
        color: white;
        opacity: 1;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 15px; 
    }

    .single-product .buy-btn:hover{
        background-color: black;
    }

</style>