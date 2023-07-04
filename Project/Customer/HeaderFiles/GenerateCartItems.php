<?php
    $sql = "SELECT pd.id, pd.name, pd.price, ci.quantity FROM cartitem ci JOIN products pd on ci.productID = pd.id where ci.customerID = $LoggedinUser";
    $result = $con->query($sql) or die($con->error);
    $TotalProducts = $result->num_rows;
    $TotalItems = 0;
    $TotalAmount = 0;
    $CL_ProductID = array();
    $CL_ProductName = array();
    $CL_Price = array();
    $CL_CartQuantity = array();
    while($row = $result->fetch_assoc()) {
        array_push($CL_ProductID, $row["id"]);
        array_push($CL_ProductName, $row["name"]);
        array_push($CL_Price, $row["price"]);
        array_push($CL_CartQuantity, $row["quantity"]);
        $TotalItems += $row["quantity"];
        $TotalAmount += ($row["price"] * $row["quantity"]);
    }
?>