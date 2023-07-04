<?php
    if(isset($_POST["reviewSubmit"])) {
        $userRating = $_POST["userRating"];
        $userReview = $_POST["userReview"];
        $UserID = $_SESSION["userID"];
        if($userRating == '0') {
            echo "please select rating first";
        } else {
            $reviewPID = $ProductID;
            $sql = "Select customerID from reviews where ProductID = $reviewPID and customerID = $UserID";
            $result = $con->query($sql) or die($con->error);
            $reviewExistingResult = $result->num_rows;
            if($reviewExistingResult > 0) {
                echo "You have already reviewed this product";
            } else {
                if($userReview == null) {
                    $sql = "insert into reviews(customerID, productID, rating, review) values($UserID, $reviewPID, $userRating, null)";
                } else {
                    $userReview = str_replace("'", "", $userReview);
                    $sql = "insert into reviews(customerID, productID, rating, review) values($UserID, $reviewPID, $userRating, '$userReview')";
                }
                $result = $con->query($sql) or die($con->error);
                header("Refresh:0");
            }
        }
    }
?>