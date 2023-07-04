<?php
    $ProductID = $_GET['pid'] ?? null;
    if($ProductID == null) {
        die("product not specified");
    }
    $sql = "SELECT pd.name, pd.price, pd.description, Img.link FROM products pd left outer join productimages Img on pd.id = Img.productID where pd.id = $ProductID";
    $result = $con->query($sql) or die($con->error);
    $ProductRow = $result->fetch_assoc();
    $sql = "SELECT quantity from inventory where productID = $ProductID";
    $result = $con->query($sql) or die($con->error);
    $StockRow = $result->fetch_assoc();
    $sql = "SELECT r.rating, r.review, ud.firstName FROM customers ud join reviews r on ud.id = r.customerID join products pd on r.productID = pd.id where pd.id = $ProductID";
    $result = $con->query($sql) or die($con->error);
    $NumOfReviews = $result->num_rows;
    $ratings = array();
    $reviews = array();
    $reviewUser = array();
    while($ReviewRow = $result->fetch_assoc()) {
        array_push($ratings, $ReviewRow["rating"]);
        array_push($reviews, $ReviewRow["review"]);
        array_push($reviewUser, $ReviewRow["firstName"]);
    }
    $avgRating = 0.0;
    $sum = 0;
    for($i=0;$i<$NumOfReviews;$i++) {
        $sum+=$ratings[$i];
    }
    if($NumOfReviews>0) {
        $avgRating = number_format((float)$sum/$NumOfReviews, 2, '.', '');
    } else {
        $avgRating = 0;
    }
?>