<?php
// Start the session
session_start();

// Check if the user is logged in by verifying if a session variable (e.g., 'username') is set
if (!isset($_SESSION['username'])) {
    header("Location: /E-Commerce/");
    exit();
}
// Include your database connection and navbar files
include_once "../condb.php";
include_once "../navbar.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="bg-light">
    <div class="container h-75 d-flex justify-content-center align-items-center">
        <div class="showcart_data"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../controller/cart.js"></script>
    <script src="../controller/login.js"></script>
    <script>
        $(document).ready(function() {
            display_cart_data();
        });

        function display_cart_data() {
            $.ajax({
                type: "POST",
                url: "cart_data.php",
                dataType: "html",
                success: function(res) {
                    $(".showcart_data").html(res);
                }
            });
        }
    </script>
</body>

</html>