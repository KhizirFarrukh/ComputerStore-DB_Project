<?php
    session_start();
    include "HeaderFiles\\db_connect.php";
    if(isset($_SESSION["userID"])) {
        $LoggedinUser = $_SESSION["userID"];
        include "HeaderFiles\\getOrders.php";
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
    <title>OrderHistory</title>
    <style>
        table {
            margin-top: 25px;
            margin-left: 40px;
            text-align: left;
        }
        table, th, td {
            font-family: sans-serif;
            border: 1px solid black;
        }
        td , th{
            padding-left: 15px;
            padding-right: 15px;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php
        include "HeaderFiles\\PageHeader.php";
    ?>
    <div class="body">
        <h1 style="font-size:40px;padding-top: 10px;padding-left: 10px;">Order History</h1>
        <?php
            if($TotalOrders == null) 
            {
                echo "<p>Order referencing failed</p>";
            } 
            elseif($TotalOrders > 0) 
            {
                echo "<div class=\"Orders\">";
                echo "<table>";
                echo "<tr id=\"ItemsHeader\">";
                echo "<th>#</th>";
                echo "<th>Order ID</th>";
                echo "<th>Order Amount</th>";
                echo "<th>Order Date</th>";
                echo "<th>Order Status</th>";
                echo "</tr>";
                for($i=0;$i<$TotalOrders;$i++) 
                {
                    echo "<tr id=\"ItemsBody\">";
                    echo "<td id=\"sno\">" . $i+1 . "</td>";
                    echo "<td id=\"id\" style=\"text-align:center;\"><a href=\"OrderItems.php?orderid=$O_OrderID[$i]\">$O_OrderID[$i]</a></td>";
                    echo "<td id=\"amount\" style=\"text-align:center;\">Rs. " . number_format($O_OrderAmount[$i]) ."</td>";
                    echo "<td id=\"date\" style=\"text-align:center;\">$O_OrderDate[$i]</td>";
                    echo "<td id=\"status\" style=\"text-align:center;\">$O_Status[$i]</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "</div>";
            }
        ?>
    </div>
</body>
</html>