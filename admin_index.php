<?php
// Start the session
session_start();

// Check if the user is logged in by verifying if a session variable (e.g., 'username') is set
if (!isset($_SESSION['username'])) {
    header("Location: /E-Commerce/view/login.php");
    exit();
}

// Include your database connection and navbar files
include_once "condb.php";
include_once "navbar_admin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-2">จัดการหนังสือ</h1>
        <div class="d-flex justify-content-between">
            <?php
            if (isset($_SESSION['fullname'])) { ?>
                <h4><i class="fa-solid fa-user"></i> สวัสดีคุณ <?= $_SESSION['fullname'] ?></h4>
            <?php  } ?>
            <button class="btn btn-outline-primary mb-3" onclick="show_md_book_add()"><i class="fa-solid fa-book-bible"></i> เพิ่มหนังสือ</button>
        </div>
        <div class="book-table"></div>
        <div class="md_book_edit"></div>
        <div class="md_book_add"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="controller/book.js"></script>
    <script src="controller/login.js"></script>
    <script>
        $(document).ready(function() {
            display_book_table();
        });

        function display_book_table() {
            $.ajax({
                type: "POST",
                url: "view/book_table.php",
                dataType: "html",
                success: function(res) {
                    $(".book-table").html(res);
                }
            });
        }
    </script>
</body>

</html>