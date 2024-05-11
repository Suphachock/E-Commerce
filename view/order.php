<?php
// Start the session
session_start();
include_once "../condb.php";

// Check if the user is logged in by verifying if a session variable (e.g., 'username') is set
if (!isset($_SESSION['userid'])) {
    header("Location: /E-Commerce/view/login.php");
    exit();
}
include_once "../navbar.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-3">คำสั่งซื้อ</h1>
        <div class="order-table"></div>
        <div class="order-detail"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../controller/login.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            display_order();
            cart_number();
        });

        function display_order() {
            fetch("order_list.php", {
                    method: "POST",
                })
                .then(response => response.text())
                .then(html => {
                    document.querySelector(".order-table").innerHTML = html;
                })
                .catch(error => console.error("Fetch error:", error));
        }

        function cart_number() {
            $.ajax({
                type: "POST",
                url: "/E-Commerce/model/count_cart.php",
                dataType: "html",
                success: function(res) {
                    $("#cart_number").html(res);
                },
            });
        }

        function order_detail(id) {
            $.ajax({
                url: "order_detail.php",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "html",
                success: function(res) {
                    $(".order-detail").html(res);
                    $("#order_detail").modal("show");
                }
            })
        }
    </script>
</body>

</html>