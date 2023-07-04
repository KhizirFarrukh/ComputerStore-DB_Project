<?php
    if($CategoryName!=null) {
        $sql = "SELECT DISTINCT pb.name FROM products pd join brands pb on pd.brandID = pb.id where pd.brandID IN (SELECT pd.brandID FROM products pd join categories pc on pd.categoryID = pc.id where pc.name = '" . $CategoryName . "')";
    } else {
        $sql = "SELECT DISTINCT pb.name FROM products pd join brands pb on pd.brandID = pb.id where pd.brandID IN (SELECT pd.brandID FROM products pd)";
    }
    $result = $con->query($sql) or die($con->error);
    $BrandsList = array();
    while($row = $result->fetch_assoc()) {
        array_push($BrandsList, $row["name"]);
    }
?>