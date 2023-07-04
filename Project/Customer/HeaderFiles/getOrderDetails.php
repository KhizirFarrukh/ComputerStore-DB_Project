<?php
    $OrderID = $_GET["orderid"] ?? null;
    if($OrderID != null) {
        $sql = "SELECT DATE_FORMAT(OrderDate, \"%d %M, %Y\") AS \"OrderDate\", totalAmount, ShippedDate, `status` FROM `order` WHERE `no` = $OrderID AND customerID = $LoggedinUser";
        $result = $con->query($sql) or die($con->error);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $OrderDate = $row["OrderDate"];
            $TotalAmount = $row["totalAmount"];
            $ShippedDate = $row["ShippedDate"];
            $Status = $row["status"];
            $OrderAccessValid = true;
        } else {
            $OrderAccessValid = false;
        }
    }
?>