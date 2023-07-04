<?php
    if($BrandName != null) {
        $sql = "SELECT pd.id, pd.name, pd.price, pd.description, pi.quantity, Img.link FROM products pd join inventory pi on pd.id = pi.productID join brands pb on pd.brandID = pb.id left outer join productimages Img on pd.id = Img.productID where pb.name = '" . $BrandName . "' and pd.price > " . $MinPrice . " and pd.price < " . $MaxPrice;
    } else {
        $sql = "SELECT pd.id, pd.name, pd.price, pd.description, pi.quantity, Img.link FROM products pd join inventory pi on pd.id = pi.productID left outer join productimages Img on pd.id = Img.productID where pd.price > " . $MinPrice . " and pd.price < " . $MaxPrice;
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
    for($i=0;$i<$NumOfProducts-1;$i++) {
        for($j=0;$j<$NumOfProducts-$i-1;$j++) {
            if($ProductPrice[$j] > $ProductPrice[$j+1]) {
                $temp = $ProductID[$j];
                $ProductID[$j] = $ProductID[$j+1];
                $ProductID[$j+1] = $temp;

                $temp = $ProductName[$j];
                $ProductName[$j] = $ProductName[$j+1];
                $ProductName[$j+1] = $temp;

                $temp = $ProductPrice[$j];
                $ProductPrice[$j] = $ProductPrice[$j+1];
                $ProductPrice[$j+1] = $temp;

                $temp = $ProductDesc[$j];
                $ProductDesc[$j] = $ProductDesc[$j+1];
                $ProductDesc[$j+1] = $temp;

                $temp = $ProductQuantity[$j];
                $ProductQuantity[$j] = $ProductQuantity[$j+1];
                $ProductQuantity[$j+1] = $temp;

                $temp = $ProductImgPath[$j];
                $ProductImgPath[$j] = $ProductImgPath[$j+1];
                $ProductImgPath[$j+1] = $temp;
            }
        }
    }
?>