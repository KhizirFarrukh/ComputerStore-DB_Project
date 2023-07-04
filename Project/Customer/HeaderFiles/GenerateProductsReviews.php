<?php
    $ProductRatings = array();
    $NumOfReviews = array();
    for($i=0;$i<$NumOfProducts;$i++) {
        $sql = "SELECT rating FROM reviews where productID = $ProductID[$i]";
        $result = $con->query($sql) or die($con->error);
        array_push($NumOfReviews, $result->num_rows);
        $sum = 0;
        for($j=0;$j<$NumOfReviews[$i];$j++) {
            $row = $result->fetch_assoc();
            $sum += (int)$row["rating"];
        }
        if($NumOfReviews[$i] == 0) {
            array_push($ProductRatings, 0);
        } else {
            array_push($ProductRatings, $sum/$NumOfReviews[$i]);
        }
    }
?>