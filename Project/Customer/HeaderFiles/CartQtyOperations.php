<?php
    if(isset($_POST["CartQtyOperation"])) {
        $NewQuantity = $_POST["CurrentQty"] + $_POST["CartQtyOperation"];
        if($NewQuantity == 0) {
            $sql = "DELETE FROM cartitem WHERE customerID = $LoggedinUser and productID = " . $_POST["PID"];
        } elseif($NewQuantity > 0) {
            $sql = "UPDATE cartitem SET quantity = $NewQuantity WHERE customerID = $LoggedinUser and productID = " . $_POST["PID"];
        }
        $result = $con->query($sql) or die($con->error);
    }
?>