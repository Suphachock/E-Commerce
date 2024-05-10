<?php
// Start the session
session_start();
include_once "condb.php";
include_once "navbar.php";
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
    <style>
        .card {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .card:hover {

            box-shadow: 5px 6px 6px 2px #e9ecef;
            transform: scale(1.03);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container ">
        <h1 class="text-center">ร้านขายหนังสือออนไลน์</h1>
        <?php
        // Fetch data from the product table
        $sql = "SELECT * FROM product ORDER BY pd_id";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="row">
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card">
                        <!-- Card Image -->
                        <img src="img/<?= htmlspecialchars($row['pd_image']) ?>" alt="<?= htmlspecialchars($row['pd_name']) ?> " height="400px">
                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['pd_name']) ?></h5>
                            <p class="card-text text-truncate"><?= htmlspecialchars($row['pd_detail']) ?></p>
                            <!-- Price and Add to Cart Button -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="card-text fw-bold text-success">ราคา ฿<?= htmlspecialchars($row['pd_price']) ?></p>
                                </div>
                                <?php if (isset($_SESSION['userid'])) { ?>
                                    <a href="#" class="btn btn-outline-primary" onclick="addCart('<?= $row['pd_id'] ?>')">
                                        <i class="fa-solid fa-cart-shopping"></i> เพิ่มลงตะกร้า
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="controller/login.js"></script>
    <script src="controller/cart.js"></script>
</body>

</html>