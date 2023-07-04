<?php
    session_start();
    $NumOfProducts = 0;
    include "HeaderFiles\\db_connect.php";
    include "HeaderFiles\\GenerateProductsList.php";
    include "HeaderFiles\\GenerateProductsReviews.php";
    include "HeaderFiles\\GenerateBrandsList.php";
    include "HeaderFiles\\GenerateCategoriesList.php";
    include "HeaderFiles\\AddProductToCart.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href=".//css/products.css">
    <script src="https://kit.fontawesome.com/85c08616f2.js" crossorigin="anonymous"></script>
    <script>
        function SubmitForm() {
            console.log("hello");
            var minPrice = parseInt(document.getElementById("minPrice").value);
            var maxPrice = parseInt(document.getElementById("maxPrice").value);
            if (minPrice < 0) {
                minPrice = 0;
            }
            if (maxPrice < 0) {
                maxPrice = 0;
            }
            var pass = 0;
            if (isNaN(minPrice) || isNaN(maxPrice)) {
                pass = 1;
            } else {
                if (minPrice <= maxPrice) {
                    pass = 1;
                }
            }
            if (pass == 1) {
                var URLParams = window.location.search;
                var newURLParams = "";
                if (URLParams.includes("category")) {
                    if (URLParams.includes("&")) {
                        let temp = URLParams.split("&");
                        newURLParams = temp[0];
                    } else {
                        newURLParams = URLParams;
                    }
                    newURLParams += "&";
                } else {
                    newURLParams = "?";
                }
                if (document.querySelector('input[name="brand"]:checked') != null) {
                    newURLParams += "brand=" + document.querySelector('input[name="brand"]:checked').value + "&";
                }
                if (!isNaN(minPrice)) {
                    newURLParams += "minPrice=" + minPrice + "&";
                }
                if (!isNaN(maxPrice)) {
                    newURLParams += "maxPrice=" + maxPrice + "&";
                }
                newURLParams = newURLParams.slice(0, -1);
                window.location.search = newURLParams;
            }
        }
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            // Prevents form resubmit message when reload
        }
    </script>
    <?php
        echo "
        <script>
            
        </script>
        ";
    ?>
</head>

<body>
    <?php
        include "HeaderFiles\\PageHeader.php";
    ?>
    <div class="body">
        <div class="filter">
            <?php
                if($SearchText==null) {
                    echo "<h2 style=\"margin-top:20px\">Filters</h2>";
                    echo "<hr>";
                    echo "<div class=\"brands\" style=\"margin-top:10px;\">";
                    echo "<h3>Brands</h3>";
                    for($i=0;$i<count($BrandsList);$i++) {
                        if($BrandName == $BrandsList[$i]) {
                            echo "
                            <input style=\"margin-left:15px\" type=\"radio\" name=\"brand\" id=\"$BrandsList[$i]\" value=\"$BrandsList[$i]\" checked>
                            <label for=\"$BrandsList[$i]\">$BrandsList[$i]</label>
                            <br>
                        ";
                        } else {
                            echo "
                                <input style=\"margin-left:15px\" type=\"radio\" name=\"brand\" id=\"$BrandsList[$i]\" value=\"$BrandsList[$i]\">
                                <label for=\"$BrandsList[$i]\">$BrandsList[$i]</label>
                                <br>
                            ";
                        }
                    }
                    echo "</div>";
                    echo "<div class=\"PriceRange\" style=\"margin-top:10px;\">";
                    echo "<h3>Price Range</h3>";
                    echo "<input name=\"minPrice\" id=\"minPrice\" type=\"number\" placeholder=\"Min\" style=\"margin-top:10px;width:100px;height:30px;font-size:20px;\">";
                    echo "<span style=\"font-size: 20px;\">&nbsp&nbsp&#8594&nbsp&nbsp</span>";
                    echo "<input name=\"maxPrice\" id=\"maxPrice\" type=\"number\" placeholder=\"Max\" style=\"margin-top:10px;width:100px;height:30px;font-size:20px;\">";
                    echo "<br>";
                    echo "</div>";
                    echo "<br><br>";
                    echo "<button onclick=\"SubmitForm();\" style=\"height:40px;width:150px;font-size:20px\">Apply Filters</button>";
                } else {
                    echo "<style>.filter{background-color:white;}</style>";
                }
            ?>
        </div>
        <div class="ProductsList">
            <?php    
                echo "<h1 style=\"margin-top:10px\">Products <span style=\"font-size:16px;font-weight:normal;font-style:italic;float:right;margin-right:2%;margin-top:10px\">Showing $NumOfProducts results...</span></h1><hr>";
                if($SearchText != null) {
                    echo "<h3>Showing search results for \"$SearchText\"</h3>";
                }
                if($NumOfProducts>0) {
                    for($i=0;$i<$NumOfProducts;$i++) {
                        $StockStats = null;
                        if($ProductQuantity[$i] > 0) {
                            $StockStats = "<span><p style=\"color:green;font-size: 20px;font-weight:bold;\">In Stock &nbsp&nbsp&nbsp
                            <button type=\"submit\" value=\"$ProductID[$i]\" name=\"AddToCart\" class=\"AddToCartButton InStock btn\"><i class=\"fa fa-shopping-cart\"> Add to Cart</i></button></p>";
                            if($AttemptToAddToCart && $ProductID[$i] == $AddToCartPID) {
                                if($AddedToCart) {
                                    $StockStats .= "<label style=\"color:green\">Product Added to cart!</label>";
                                } else {
                                    $StockStats .= "<label style=\"color:red\">&nbsp Please Login first</label>";
                                }
                            }
                            $StockStats .= "</span><br>";
                        } else {
                            $StockStats = "<span><p style=\"color:red;font-size: 20px;font-weight:bold;\">Out Of Stock &nbsp&nbsp&nbsp
                            <button class=\"AddToCartButton OutOfStock btn\" disabled><i class=\"fa fa-shopping-cart\"> Add to Cart</i></button></p></span><br>";
                        }
                        $ReviewLine = "$NumOfReviews[$i] rating(s) ";
                        $StarWidth = 0;
                        if($NumOfReviews[$i] > 0) {
                            $StarWidth = (number_format((float)$ProductRatings[$i], 2, '.', '')/5) * 100;
                        }
                        echo "<div class=\"productMain\">";
                        echo "<div class=\"productImg\">";
                        echo "<img src=\"..\\Admin\\public\\images\\products\\". $ProductImgPath[$i] . "\" alt=\"". $ProductName[$i] . "\" style=\"width:225px;height:225px;\">";
                        echo "</div>";
                        echo "<div class = \"productInfo\">";
                        echo "<h2 style=\"font-size:26px\" class=\"ProductName\"><a href=\"productDetails.php?pid=$ProductID[$i]\">$ProductName[$i]</a></h2>";
                        echo "<br><h3 style=\"font-size:24px\">Rs. " . number_format($ProductPrice[$i]) . "</h3><br>";
                        echo "<form action=\"" . str_replace("/DB_Project/", "", $_SERVER["REQUEST_URI"]) . "\" method=\"POST\">";
                        echo "$StockStats";
                        echo "</form>";
                        echo "<span style=\"font-size:20px\"> $ReviewLine </span>";
                        echo "<div class=\"stars-outer\"><div class=\"stars-inner\" style=\"width:$StarWidth%\"></div></div><span class=\"number-rating\"></span>";
                        echo "<br><br><p class=\"desc\">$ProductDesc[$i]</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<hr>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>