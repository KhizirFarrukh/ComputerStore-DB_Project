<?php
// Changing required
    $sql = "SELECT `no`, DATE_FORMAT(OrderDate, \"%d %M, %Y\") AS \"OrderDate\", totalAmount, `status` FROM `order` WHERE customerID = $LoggedinUser";
    $result = $con->query($sql) or die($con->error);
    $TotalOrders = $result->num_rows;
    $O_OrderID = array();
    $O_OrderDate = array();
    $O_OrderAmount = array();
    $O_Status = array();
    while($row = $result->fetch_assoc()) {
        array_push($O_OrderID, $row["no"]);
        array_push($O_OrderDate, $row["OrderDate"]);
        array_push($O_OrderAmount, $row["totalAmount"]);
        array_push($O_Status, $row["status"]);
    }
?>