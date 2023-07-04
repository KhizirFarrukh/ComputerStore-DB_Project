<?php
    if($OrderID != null) {
        $sql = "SELECT pd.name, oi.quantity, oi.amount FROM orderitems oi JOIN products pd ON oi.productID = pd.id WHERE orderNo = $OrderID";
        $result = $con->query($sql) or die($con->error);
        $TotalOrderItems = $result->num_rows;
        $OI_ProductName = array();
        $OI_Quantity = array();
        $OI_Price = array();
        $OI_TotalAmount = array();
        while($row = $result->fetch_assoc()) {
            array_push($OI_ProductName, $row["name"]);
            array_push($OI_Quantity, $row["quantity"]);
            array_push($OI_TotalAmount, $row["amount"]);
            array_push($OI_Price, $row["amount"] / $row["quantity"]);
        }
    }
?>