<?php
    $AddedToCart = false;
    $AttemptToAddToCart = false;
    $AddToCartPID = -1;
    if(isset($_POST["AddToCart"])) {
        $AddToCartPID = $_POST["AddToCart"];
        $AttemptToAddToCart = true;
        if(isset($_SESSION["userID"])) {
            $AddToCartPID = $_POST["AddToCart"];
            $LoggedInUser = $_SESSION["userID"];
            $sql = "SELECT * FROM cartitem WHERE productID = $AddToCartPID and customerID = $LoggedInUser";
            $result = $con->query($sql) or die($con->error);
            if($result->num_rows == 0) {
                $sql = "INSERT INTO cartitem VALUES($LoggedInUser, $AddToCartPID, 1)";
                $result = $con->query($sql) or die($con->error);
            } else {
                $row = $result->fetch_assoc();
                $Qty = $row["quantity"];
                $Qty++;
                $sql = "UPDATE cartitem SET quantity = $Qty WHERE productID = $AddToCartPID and customerID = $LoggedInUser";
                $result = $con->query($sql) or die($con->error);
            }
            $AddedToCart = true;
        }
    }
?>