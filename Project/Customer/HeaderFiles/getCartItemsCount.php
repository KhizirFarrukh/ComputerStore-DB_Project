<?php
    if(isset($_SESSION["userID"])) {
        $sql = "SELECT count(productID) AS \"CartItemCount\" from cartitem where customerID = " . $_SESSION["userID"];
        $result = $con->query($sql) or die($con->error);
        $row = $result->fetch_assoc();
        $CartItemsCount = $row["CartItemCount"];
    }
?>