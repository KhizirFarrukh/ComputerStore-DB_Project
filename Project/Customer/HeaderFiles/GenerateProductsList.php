<?php
    $MinPrice = $_GET['minPrice'] ?? 0;
    $MaxPrice = $_GET['maxPrice'] ?? 2147483647;
    $CategoryName = $_GET['category'] ?? null;
    $SearchText = $_GET['SearchText'] ?? null;
    $BrandName = $_GET['brand'] ?? null;
    if($CategoryName != null) {
        include "categoryFunction.php";
    } elseif($SearchText != null) {
        include "searchFunction.php";
    } else {
        include "basicProductsPageFunction.php";
    }
?>