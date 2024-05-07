<?php include_once "condb.php" ?>
<?php include_once "navbar.php" ?>
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
        <div class="row mt-5">
            <div class="col">
                <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM product
                INNER JOIN type ON product.type_id = type.type_id
                WHERE product.pro_id = $id";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) { ?>
                    <img src="img/<?= $row['image'] ?>" class="rounded mx-auto d-block" width="300px">
            </div>
            <div class="col">
                <h1><?= $row['pro_name'] ?></h1>
                <p>รายละเอียด <?= $row['detail'] ?></p>
                <h3>หมวดหมู่ <?= $row['type_name'] ?></h3>
                <h3>ราคา <?= $row['price'] ?> บาท</h3>
                <button class="btn btn-success mt-2">เพิ่มลงตะกร้า</button>
            </div>
        <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>