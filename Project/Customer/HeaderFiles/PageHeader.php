<?php
    include "db_connect.php";
    include "GenerateCategoriesList.php";
    include "GetUserFullName.php";
    include "getCartItemsCount.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./css/NavBar.css">
    <link rel="stylesheet" href="./css/PageHeader.css">
    <script src="https://kit.fontawesome.com/85c08616f2.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main">
        <div class="header">
            <div class="title">
                <a href="products.php" style="color: black;">
                    <img src="PageImg/ComputerStoreLogo.jpeg" style="height: 64px; width: 188;">
                </a>
            </div>
            <div class="SearchBar">
                <form action="products.php" method="GET" style="height:100%">
                    <input type="text" class="TextBox" name="SearchText" placeholder="Search (E.g. Asus RTX 3080)" id="SearchInput" style="width: 70%;height: 80%;">
                    <button id="SearchButton" type="submit" style="width: 100px; height: 41px;"><i class="fas fa-search"> Search</i></button>
                </form>
            </div>
            <div class="Account">
                <?php
                    if($UserName !="") {
                        echo "<button ID=\"GoToCart\" onclick=\"window.location='cart.php'\" style=\"width: 100px; height: 41px;margin-right:10px\"><i class=\"fa fa-shopping-cart\"> My Cart <br>($CartItemsCount items)</i></button>";
                        echo "<button ID=\"UserAccount\" onclick=\"window.location='account.php'\" style=\"width: 130px; height: 41px;margin-right:10px\"><i class=\"fa fa-solid fa-user\"> $UserName</i></button>";
                        echo "<a href=\"logout.php\" style=\"padding-top:4%\">Logout</a>";
                    } else {
                        echo "<button ID=\"Login\" onclick=\"window.location='login.php'\" style=\"margin-left:30%;width: 100px; height: 41px\">Log in</button>";
                    }
                ?>
                
            </div>
        </div>
        <div class="NavBar">
            <nav style="font-family: Arial">
                <ul style="padding-left:16%;padding-right:14%;">
                    <li style="float:center "><a class="active " href="#home ">Home</a></li>
                    <li class="dropdown"><a class="dropbtn">Products</a>
                        <div class="dropdown-content">
                            <?php
                                for($i=0;$i<count($CategoriesList);$i++) {
                                    $tempCatName = str_replace(" ", "+", $CategoriesList[$i]);
                                    echo "<a href=\"./products.php?category=$tempCatName\">$CategoriesList[$i]</a>";
                                }
                            ?>
                        </div>
                    </li>
                    <li><a href="#contact ">Contact Us</a></li>
                    <li><a href="#about ">About</a></li>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>