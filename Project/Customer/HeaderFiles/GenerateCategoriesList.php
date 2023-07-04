<?php
    $sql = "SELECT name FROM categories";
    $result = $con->query($sql) or die($con->error);
    $CategoriesList = array();
    while($row = $result->fetch_assoc()) {
        array_push($CategoriesList, $row["name"]);
    }
?>