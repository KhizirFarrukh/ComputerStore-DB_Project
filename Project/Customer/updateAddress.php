<?php
    session_start();
    include "HeaderFiles\\db_connect.php";
    if(isset($_POST['update']))
    {
        $LoggedInUser = $_SESSION["userID"];
        $AddressLine = $_POST["AddressLine"];
        $City = $_POST["City"];
        $State = $_POST["State"];
        $Zipcode = $_POST["Zipcode"];
        
        $sql = "SELECT id FROM customeraddress WHERE id=$LoggedInUser";
        $query_run = mysqli_query($con, $sql);
        if($query_run->num_rows > 0) {
            $sql = "UPDATE customeraddress SET addressLine = '$AddressLine', `state` = '$State', city = '$City', zipCode = '$Zipcode' WHERE id=$LoggedInUser";
        } else {
            $sql = "INSERT INTO customeraddress VALUES($LoggedInUser, '$AddressLine', '$State', '$City', '$Zipcode')";
        }
        if($con->query($sql)) {
            echo '<script type="text/javascript"> alert("Updated Successfully") </script>';
        } else {
            die($con->error);
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title> UpdateAddress </title>
        <style>
            body{
                background-color: whitesmoke;
            }
            input{
                width: 20%;
                height: 5%;
                border: none;
                border-radius: 5px;
                padding: 10px 15px;
                margin: 10px 0px;
                box-shadow: 1px 2px grey;
            }
            .body {
                margin-left: 20%;
                font-family: sans-serif;
            }
        </style>
    </head>
    <body>
        <?php
            include "HeaderFiles\\PageHeader.php";
        ?>
        <div class="body">
            <h1>Change Address</h1>
            <form action="updateAddress.php" method="POST">
                <input type="text" name="AddressLine" placeholder="Address Line" required>
                <br>
                <input type="text" name="State" placeholder="State" style="width=10%" required>
                <br>
                <input type="text" name="City" placeholder="City" required>
                <br>
                <input type="text" name="Zipcode" placeholder="ZipCode" required>
                <br>
                <input type="submit" name="update" value="Save" required>
                <br>
            </form>
        </div>
    </body>
</html>