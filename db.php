<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "mallt";
        // Create connection
        $con = mysqli_connect($servername, $username, $password,$db);
        // Check connection
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        ?>
    </body>
</html>
