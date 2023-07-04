<?php
    session_start();
    $NumOfProducts = 0;
    include "HeaderFiles\\db_connect.php";
    include "HeaderFiles\\getProductDetails.php";
    include "HeaderFiles\\AddProductReview.php";
    include "HeaderFiles\\AddProductToCart.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href=".//css/productDetails.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://kit.fontawesome.com/85c08616f2.js" crossorigin="anonymous"></script>
    <script>
        window.onload = function() {
            document.getElementByName("reviewForm").action = window.location.href;
        }
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            // Prevents form resubmit message when reload
        }
    </script>
</head>
<body>
    <?php
        include "HeaderFiles\\PageHeader.php";
        echo "<div class=\"productDetailsHeader\">";
        echo "<div class=\"productImg\">";
        echo "<img src=\"..\\Admin\\public\\images\\products\\". $ProductRow["link"] . "\" alt=\"". $ProductRow["name"] . "\" style=\"width:400px;height:400px;\">";
        echo "</div>";
        echo "<div class = \"productInfo\">";
        echo "<h1 class=\"ProductRow\">" . $ProductRow["name"] . "</h1>";
        echo "<h2 class=\"PriceRow\"> Rs." . number_format($ProductRow["price"]) . "</h2>";
        echo "<form action=\"" . str_replace("/DB_Project/", "", $_SERVER["REQUEST_URI"]) . "\" method=\"POST\">";
        if($StockRow["quantity"] > 0) {
            echo "<h2 class=\"StockRow\" style=\"color:green\">In Stock &nbsp&nbsp&nbsp<span>";
            echo "<button type=\"submit\" value=\"$ProductID\" name=\"AddToCart\" class=\"AddToCardButton InStock btn\"><i class=\"fa fa-shopping-cart\"> Add to Cart</i></button></span></h2>";
        } else {
            echo "<h2 class=\"StockRow\" style=\"color:red\">Out of Stock &nbsp&nbsp&nbsp<span>";
            echo "<button class=\"AddToCardButton OutOfStock btn\" disabled><i class=\"fa fa-shopping-cart\"> Add to Cart</i></button></span></h2>";
        }
        echo "</form>";
        $ReviewLine = "$NumOfReviews rating(s) ";
        $StarWidth = 0;
        if($NumOfReviews > 0) {
            $StarWidth = (number_format((float)$avgRating, 2, '.', '')/5) * 100;
        }
        echo "<h3 style=\"font-size:20px\"> $ReviewLine </h3>";
        echo "<div class=\"stars-outer\"><div class=\"stars-inner\" style=\"width:$StarWidth%\"></div></div><span class=\"number-rating\"></span>";
        echo "<h4 style=\"margin-top:10px;\"> Description </h4> <hr>";
        echo "<p>" . $ProductRow["description"] .  "</p> <hr>";
        echo "</div>";
        echo "</div>";
        ?>
        <div class="reviews">
            <br><h2>Provide your Review</h2><hr>
            <form name="reviewForm" method="post">
                <div class="rate">
                    <input type="radio" id="star5" name="userRating" value=5 />
                    <label for="star5" title="rating">5 stars</label>
                    <input type="radio" id="star4" name="userRating" value=4 />
                    <label for="star4" title="rating">4 stars</label>
                    <input type="radio" id="star3" name="userRating" value=3 />
                    <label for="star3" title="rating">3 stars</label>
                    <input type="radio" id="star2" name="userRating" value=2 />
                    <label for="star2" title="rating">2 stars</label>
                    <input type="radio" id="star1" name="userRating" value=1 />
                    <label for="star1" title="rating">1 star</label>
                </div>
                <br><br><br>
                <textarea id="userReview" name="userReview" placeholder="Review (optional)" rows=5 cols=100 style="padding-left:10px;padding-right:10px;padding-top:5px;"></textarea><br><br>
                <?php
                    if(isset($_SESSION["userID"])) {
                        echo "<button ID=\"SubmitReview\" type=\"submit\" name=\"reviewSubmit\" style=\"width:120px;height:28px;font-weight:bold\">Submit Review</button>";
                    } else {
                        echo "<button ID=\"SubmitReview\" type=\"submit\" name=\"reviewSubmit\" disabled style=\"width:120px;height:28px;font-weight:bold\">Submit Review</button>";
                        echo "<span>You need to login first</span>";
                    }
                ?>
            </form>
        <?php
        echo "<br><h2>Reviews</h2><hr>";
        for($i=0;$i<$NumOfReviews;$i++) {
            if($reviews[$i] != null) {
                echo "<h3 style=\"font-weight:normal\">$reviewUser[$i] : $ratings[$i] / 5 stars</h5>";
                echo "<p>&nbsp&nbsp&nbsp&#8594 $reviews[$i]</p>";
            }
        }
        if($NumOfReviews == 0) {
            echo "<p style=\"font-style:italic\">&nbsp&nbspThis product currently has no reviews</p>";
        }
        ?>
        </div>
</body>
</html>