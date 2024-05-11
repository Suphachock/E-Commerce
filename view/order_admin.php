<?php
// Start the session
session_start();
include_once "../condb.php";

if (!isset($_SESSION['userid'])) {
    header("Location: /E-Commerce/view/login.php");
    exit();
}
include_once "../navbar_admin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-3">คำสั่งซื้อ</h1>
        <div class="order-table"></div>
        <div class="order-detail"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../controller/login.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            display_order();
        });

        function display_order() {
            fetch("admin_order_list.php", {
                    method: "POST",
                })
                .then(response => response.text())
                .then(html => {
                    document.querySelector(".order-table").innerHTML = html;
                })
                .catch(error => console.error("Fetch error:", error));
        }

        function admin_order_detail(id) {
            $.ajax({
                url: "admin_order_detail.php",
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

        function admin_order_confirm(id) {
            $.ajax({
                type: "POST",
                url: "/E-Commerce/model/update_order.php",
                data: {
                    id: id
                },
                success: function(res) {
                    if (res === "Update success") {
                        $("#order_detail").modal("hide");
                        display_order()
                        Toastify({
                            text: "อัพเดทคำสั่งซื้อแล้ว",
                            duration: 1200,
                            gravity: "top",
                            position: "right",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            },
                        }).showToast();
                    } else {
                        alert(res)
                    }
                }
            })
        }

        function admin_order_cancel(id) {
            $.ajax({
                type: "POST",
                url: "/E-Commerce/model/cancel_order.php",
                data: {
                    id: id
                },
                success: function(res) {
                    if (res === "Update success") {
                        $("#order_detail").modal("hide");
                        display_order()
                        Toastify({
                            text: "ยกเลิกคำสั่งซื้อแล้ว",
                            duration: 1200,
                            gravity: "top",
                            position: "right",
                            style: {
                                background: "linear-gradient(to right, #f44336, #f48236)",
                            },
                        }).showToast();
                    } else {
                        alert(res)
                    }
                }
            })
        }
    </script>
</body>

</html>