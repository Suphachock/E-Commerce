<?php include_once "condb.php" ?>
<?php include_once "navbar.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <h1 class="text-center mt-2">ร้านขายหนังสือออนไลน์</h1>
        <?php
        // Fetch data from the product table
        $sql = "SELECT * FROM product ORDER BY pd_id";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="row">
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <div class="col-md-3 col-sm-3 mb-4">
                    <div class="card">
                        <img src="img/<?= htmlspecialchars($row['pd_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['pd_name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['pd_name']) ?></h5>
                            <p class="card-text text-truncate"><?= htmlspecialchars($row['pd_detail']) ?></p>
                            <div class="text-end">
                                <p class="card-text">ราคา <?= htmlspecialchars($row['pd_price']) ?> บาท</p>
                                <a href="pd_detail.php?id=<?= $row['pd_id'] ?>" class="btn btn-primary">รายละเอียด</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>