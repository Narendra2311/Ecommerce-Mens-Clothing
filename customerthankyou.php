<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="login.css">
        <script>
            $(document).ready(function () {
                $(".val").keypress(function (e) {
                    var N = e.which;
                    if (N < 48 || N > 57)
                        e.preventDefault();
                });
            });

        </script>
    </head>
    <body>
       
        <div class="container" id="container"  >
            <form action="customerlogin.php">
            <center><h1>Thank You For Registration</h1>
            <button name="log">Go for Login</button></center>
            </form>
        </div>
        <?php
        ?>
        <script src="login.js"></script>
    </body>
</html>
