<?php
    $SearchTextWords = explode(" ", $SearchText);
    $ProdOccurrence = array();
    $ProductID = array();
    $ProductName = array();
    $ProductPrice = array();
    $ProductDesc = array();
    $ProductQuantity = array();
    $ProductImgPath = array();
    $NumOfProducts = 0;
    for($i=0;$i<count($SearchTextWords);$i++) {
        $sql = "SELECT pd.id, pd.name, pd.price, pd.description, pi.Quantity, Img.link FROM products pd join inventory pi on pd.id = pi.ProductID left outer join productimages Img on pd.id = Img.productID where pd.price > " . $MinPrice . " and pd.price < " . $MaxPrice . " and name LIKE '%" . $SearchTextWords[$i] . "%'";
        $result = $con->query($sql) or die($con->error);
        while($row = $result->fetch_assoc()) {
            $found=0;
            for($j=0;$j<count($ProductName);$j++) {
                if($ProductName[$j] == $row["name"]) {
                    $ProdOccurrence[$j] += 1;
                    $found = 1;
                }
            }
            if($found == 0) {
                $NumOfProducts++;
                array_push($ProductID, $row["id"]);
                array_push($ProductName, $row["name"]);
                array_push($ProductPrice, $row["price"]);
                array_push($ProductDesc, $row["description"]);
                array_push($ProductQuantity, $row["Quantity"] ?? 0);
                array_push($ProdOccurrence, 1);
                array_push($ProductImgPath, $row["link"] ?? NULL);
            }
        }
    }
    for($i=0;$i<$NumOfProducts-1;$i++) {
        for($j=0;$j<$NumOfProducts-$i-1;$j++) {
            if($ProdOccurrence[$j] < $ProdOccurrence[$j+1]) {
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

                $temp = $ProdOccurrence[$j];
                $ProdOccurrence[$j] = $ProdOccurrence[$j+1];
                $ProdOccurrence[$j+1] = $temp;

                $temp = $ProductImgPath[$j];
                $ProductImgPath[$j] = $ProductImgPath[$j+1];
                $ProductImgPath[$j+1] = $temp;
            }
        }
    }
?>