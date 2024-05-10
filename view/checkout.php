<?php
// Start the session
session_start();

// Check if the user is logged in by verifying if a session variable (e.g., 'username') is set
if (!isset($_SESSION['userid'])) {
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
    <div class="container h-75 d-flex justify-content-center">
        <form id="checkout">
            <div class="showcart_data"></div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../controller/cart.js"></script>
    <script src="../controller/login.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            display_cart_data();
            $("#checkout").on("submit", function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                // Display the key/value pairs
                // for (var pair of formData.entries()) {
                //     console.log(pair[0] + ", " + pair[1]);
                // }
                $.ajax({
                    url: '../model/add_order.php', // The URL of your PHP script
                    type: 'POST', // The HTTP method to use (POST)
                    data: formData, // The form data
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting a default content type
                    success: function(res) {
                        if (res === "Order placed successfully.") {
                            alert(res)
                            window.location.replace("/E-Commerce/view/order.php");
                        } else {
                            alert(res)
                        }
                    }
                });
            });
        });

        function display_cart_data() {
            fetch("cart_data.php", {
                    method: "POST",
                })
                .then(response => response.text())
                .then(html => {
                    document.querySelector(".showcart_data").innerHTML = html
                })
                .catch(err => console.log("Error :", err))
        }
    </script>
</body>

</html>