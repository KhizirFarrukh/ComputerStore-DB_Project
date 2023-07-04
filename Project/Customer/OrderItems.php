<?php
    session_start();
    include "HeaderFiles\\db_connect.php";
    if(isset($_SESSION["userID"])) {
        $LoggedinUser = $_SESSION["userID"];
        include "HeaderFiles\\getOrderDetails.php";
        include "HeaderFiles\\GenerateOrderItems.php";
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
    <title>Order Items</title>
    <link rel="stylesheet" href=".//css/orderitems.css">
</head>
<body>
    <?php
        include "HeaderFiles\\PageHeader.php";
        if($OrderID == null) {
            echo "<p>Order referencing failed</p>";
        } else {
            if($OrderAccessValid) {
                echo "<div class=\"body\">";
                echo "<div class=\"OrderDetails\">";
                echo "<h1>Order Details</h1>";
                echo "<h3 style=\"padding-left:20px;\">Order ID : <span style=\"font-weight:normal;\">$OrderID</span></h3>";
                echo "<h3 style=\"padding-left:20px;\">Order Date : <span style=\"font-weight:normal;\">$OrderDate</span></h3>";
                echo "<h3 style=\"padding-left:20px;\">Order Amount : <span style=\"font-weight:normal;\">Rs. " . number_format($TotalAmount) ."</span></h3>";
                echo "<h3 style=\"padding-left:20px;\">Status : <span style=\"font-weight:normal;\">$Status</span></h3>";
                echo "</div>";
                echo "<div class=\"OrderItems\">";
                echo "<table>";
                echo "<tr id=\"ItemsHeader\">";
                echo "<th>#</th>";
                echo "<th>Product Name</th>";
                echo "<th>Price</th>";
                echo "<th>Quantity</th>";
                echo "<th>Total</th>";
                echo "</tr>";
                for($i=0;$i<$TotalOrderItems;$i++) {
                    echo "<tr id=\"ItemsBody\">";
                    echo "<td id=\"sno\">" . $i+1 . "</td>";
                    echo "<td id=\"PName\">$OI_ProductName[$i]</td>";
                    echo "<td id=\"Price\">Rs. " . number_format($OI_Price[$i]) ."</td>";
                    echo "<td id=\"Quantity\">$OI_Quantity[$i]</td>";
                    echo "<td id=\"TotalAmount\">Rs. " . number_format($OI_TotalAmount[$i]) ."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "Error 404: Order not found";
            }
        }
    ?>
</body>
</html>