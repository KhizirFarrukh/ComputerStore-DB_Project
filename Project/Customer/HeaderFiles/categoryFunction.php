<?php
    if($BrandName != null) {
        $sql = "SELECT pd.id, pd.name, pd.price, pd.description, pi.quantity, Img.link FROM products pd join categories pc on pd.categoryID = pc.id join inventory pi on pd.id = pi.productID join brands pb on pd.brandID = pb.id left outer join productimages Img on pd.id = Img.productID where pc.name = '" . $CategoryName . "' and pb.name = '" . $BrandName . "' and pd.price > " . $MinPrice . " and pd.price < " . $MaxPrice;
    } else {
        $sql = "SELECT pd.id, pd.name, pd.price, pd.description, pi.quantity, Img.link FROM products pd join categories pc on pd.categoryID = pc.id join inventory pi on pd.id = pi.productID left outer join productimages Img on pd.id = Img.productID where pc.name = '" . $CategoryName . "' and pd.price > " . $MinPrice . " and pd.price < " . $MaxPrice;
    }
    $result = $con->query($sql) or die($con->error);
    $NumOfProducts = $result->num_rows;
    $ProductID = array();
    $ProductName = array();
    $ProductPrice = array();
    $ProductDesc = array();
    $ProductQuantity = array();
    $ProductImgPath = array();
    while($row = $result->fetch_assoc()) {
        array_push($ProductID, $row["id"]);
        array_push($ProductName, $row["name"]);
        array_push($ProductPrice, $row["price"]);
        array_push($ProductDesc, $row["description"]);
        array_push($ProductQuantity, $row["quantity"] ?? 0);
        array_push($ProductImgPath, $row["link"] ?? NULL);
    }
?>