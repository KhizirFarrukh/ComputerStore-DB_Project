<?php
// Changing required
if(isset($_POST["PlaceOrder"]) && $AddressFetched==true) {
    $TotalOrderAmount = 0;
    $sql = "INSERT INTO `order` (customerID) VALUES($LoggedinUser)";
    $result = $con->query($sql) or die($con->error);
    $lastID = $con->insert_id;
    for($i=0;$i<$TotalProducts;$i++) {
        $sql = "SELECT quantity FROM inventory WHERE productID = $CL_ProductID[$i]";
        $result = $con->query($sql) or die($con->error);
        $row = $result->fetch_assoc();
        $ProductInventQty = $row["quantity"];
        if($ProductInventQty > 0) {
            if($ProductInventQty < $CL_CartQuantity[$i]) {
                $CL_CartQuantity[$i] = $ProductInventQty;
            }
            $CartTotalAmount = $CL_CartQuantity[$i] * $CL_Price[$i];
            $TotalOrderAmount += $CartTotalAmount;
            $sql = "INSERT INTO orderitems VALUES($lastID, $CL_ProductID[$i], $CL_CartQuantity[$i], $CartTotalAmount)";
            $result = $con->query($sql) or die($con->error);
            $ProductInventQty -=  $CL_CartQuantity[$i];
            $sql = "UPDATE inventory SET quantity = $ProductInventQty WHERE productID = $CL_ProductID[$i]";
            $result = $con->query($sql) or die($con->error);
        }
    }
    $sql = "UPDATE `order` SET totalAmount = $TotalOrderAmount WHERE `no` = $lastID";
    $result = $con->query($sql) or die($con->error);
    if($TotalOrderAmount == 0) {
        $sql = "UPDATE `order` SET `status` = 'FAILED' WHERE `no` = $lastID";
        $result = $con->query($sql) or die($con->error);
    }
    $sql = "DELETE FROM cartitem WHERE customerID = $LoggedinUser";
    $result = $con->query($sql) or die($con->error);
    header("Location: products.php");
}
?>