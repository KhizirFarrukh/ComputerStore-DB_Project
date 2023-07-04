<?php
    session_start();
    $NumOfCartItems = 0;
    include "HeaderFiles\\db_connect.php";
    if(isset($_SESSION["userID"])) {
        $LoggedinUser = $_SESSION["userID"];
        include "HeaderFiles\\CartQtyOperations.php";
        include "HeaderFiles\\GenerateCartItems.php";
        include "HeaderFiles\\getDeliveryAddress.php";
        include "HeaderFiles\\PlaceOrder.php";
    } else {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href=".//css/cart.css">
    <link rel="stylesheet" href="./css/NavBar.css">
    <link rel="stylesheet" href="./css/PageHeader.css">
    <script src="https://kit.fontawesome.com/85c08616f2.js" crossorigin="anonymous"></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            // Prevents form resubmit message when reload
        }
    </script>
</head>

<body>
    <?php
        include "HeaderFiles\\PageHeader.php";
    ?>
    <div class="body">
        <div class="cart">
            <h1 style="font-size:40px;padding-top: 10px;padding-left: 10px;">Your Cart</h1>
            <?php
                if($TotalProducts == 0) {
                    echo "<p style=\"padding-left:30px;margin-top:10px;\">Your cart is empty<p>";
                } elseif($TotalProducts > 0) {
                    echo "<table>";
                    echo "<tr id=\"ItemsHeader\">";
                    echo "<th>Product Name</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Price</th>";
                    echo "</tr>";
                    for($i=0;$i<$TotalProducts;$i++) {
                        $TotalPrice = $CL_CartQuantity[$i] * $CL_Price[$i];
                        echo "<tr id=\"ItemsBody\">";
                        echo "<td id=\"PName\">$CL_ProductName[$i]</td>";
                        echo "<form action=\"" . str_replace("/DB_Project/", "", $_SERVER["REQUEST_URI"]) . "\" method=\"POST\">";
                        echo "<td id=\"Qty\"><button type=\"submit\" value=\"-1\" name=\"CartQtyOperation\" class=\"QtyAdjust\"><i class=\"fa fa-minus\"></i></button> $CL_CartQuantity[$i] <button type=\"submit\" value=\"1\" name=\"CartQtyOperation\" class=\"QtyAdjust\"><i class=\"fa fa-plus\"></i></button></td>";
                        echo "<input type=\"hidden\" value=\"$CL_ProductID[$i]\" name=\"PID\">";
                        echo "<input type=\"hidden\" value=\"$CL_CartQuantity[$i]\" name=\"CurrentQty\">";
                        echo "</form>";
                        echo "<td id=\"Price\">Rs. " . number_format($TotalPrice) ."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                    echo "<div class=\"Checkout\">";
                    echo "<h1 style=\"font-size:40px;padding-top: 10px;padding-left: 10px;\">Summary</h1>";
                    echo "<br>";
                    echo "<h2>Total Products : <span style=\"font-weight: normal;\">$TotalProducts</span></h2>";
                    echo "<h2>Total Items : <span style=\"font-weight: normal;\">$TotalItems</span></h2>";
                    echo "<h2>Total Amount : <span style=\"font-weight: normal;\">Rs. " . number_format($TotalAmount) . "</span></h2>";
                    echo "<h2>Delivery Address :</h2><br>";
                    if($AddressFetched == true) {
                        echo "<h4>Address Line : <span style=\"font-weight: normal;\">$AddressLine</span></h4>";
                        echo "<h4>State : <span style=\"font-weight: normal;\">$State</span></h4>";
                        echo "<h4>City : <span style=\"font-weight: normal;\">$City</span></h4>";
                        echo "<h4>Zipcode : <span style=\"font-weight: normal;\">$Zipcode</span></h4>";
                        echo "<p style=\"font-style: italic;font-size: 14px;\">&nbsp Click <a href=\"updateAddress.php\">here</a> to update delivery address</p>";
                    }
                    else {
                        echo "<p style=\"font-style: italic;font-size: 14px;\">&nbsp You have not provided your delivery address <br>&nbsp Click <a href=\"updateAddress.php\">here</a> to add delivery address</p>";
                    }
                    echo "<br>";
                    echo "<form action=\"cart.php\" method=\"POST\">";
                    echo "<input type=\"checkbox\" required><label>&nbsp I accept that above mentioned details are correct</label>";
                    echo "<br>";
                    echo "<input type=\"checkbox\" required><label>&nbsp I accept the terms and conditions</label>";
                    echo "<br><br>";
                    echo "<button class=\"PlaceOrder\" name=\"PlaceOrder\">Place Order <i class=\"fas fa-angle-right\"></i></button>";
                    echo "</form>";
                    echo "<br>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</body>
</html>