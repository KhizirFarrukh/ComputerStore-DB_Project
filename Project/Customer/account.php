<?php
    session_start();
    include "HeaderFiles\\db_connect.php";
    if(isset($_SESSION["userID"])){
        $LoggedInUser = $_SESSION["userID"];
        $sql = "SELECT ud.email, ud.firstName, ud.lastName, ud.phoneNumber, ua.addressLine, ua.state, ua.city, ua.zipCode FROM customers ud LEFT OUTER JOIN customeraddress ua ON ud.id = ua.id WHERE ud.id = $LoggedInUser";
        $result = $con->query($sql) or die($con->error);
        $row = $result->fetch_assoc();
        $email =  $row["email"];
        $Fullname = $row["firstName"] . " " . $row["lastName"];
        $phonenumber = $row["phoneNumber"];
        $AddressLine = $row["addressLine"];
        $State = $row["state"];
        $City = $row["city"];
        $Zipcode = $row["zipCode"];
    } else {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <style>
        .body {
            margin-top: 5%;
            margin-left: 20%;
            font-family: sans-serif;
            display: flex;
            flex-wrap: wrap;
        }
        .AccountBtn {
            width: 200px;
            height: 100px;
            font-size: 36px;
            font-weight: bold;
        }
        .AccDetails {
            margin-top: 3%;
            margin-left: 5%;
        }
    </style>
</head>
<body>
        <?php
            include "HeaderFiles\\PageHeader.php";
        ?>
    <div class="body">
        <div class="navigator">
            <button class="AccountBtn" onclick="location.href = 'OrderHistory.php'">Order History</button><br>
            <button class="AccountBtn" onclick="location.href = 'updateAddress.php'">Update Address</button><br>
            <button class="AccountBtn" onclick="location.href = 'updatePassword.php'">Update Password</button><br>
        </div>
        <div class="AccDetails">
            <h3>Name : <span style="font-weight:normal;"><?php echo $Fullname; ?></span></h3>
            <h3>Phone Number : <span style="font-weight:normal;"><?php echo $phonenumber; ?></span></h3>
            <h3>Email Address : <span style="font-weight:normal;"><?php echo $email; ?></span></h3><br><br>
            <h2>Delivery Address : </h2>
            <h3>Address Line : <span style="font-weight:normal;"><?php echo $AddressLine; ?></span></h3>
            <h3>City : <span style="font-weight:normal;"><?php echo $City; ?></span></h3>
            <h3>State : <span style="font-weight:normal;"><?php echo $State; ?></span></h3>
            <h3>Zipcode : <span style="font-weight:normal;"><?php echo $Zipcode; ?></span></h3>
        </div>
    </div>
</body>
</html>