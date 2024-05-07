<?php include_once "condb.php" ?>
<?php include_once "navbar_admin.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-2">จัดการหนังสือ</h1>
        <div class="text-end"><button class="btn btn-primary mb-3" onclick="show_md_book_add()">เพิ่มหนังสือ</button></div>
        <div class="book-table"></div>
        <div class="md_book_edit"></div>
        <div class="md_book_add"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="controller/book.js"></script>
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