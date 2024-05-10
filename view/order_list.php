<?php include_once "../condb.php"; ?>
<div class="container mt-4">
    <table class="table table-striped table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th scope="col">ไอดี</th>
                <th scope="col">สินค้า</th>
                <th scope="col">ราคารวม(บาท)</th>
                <th scope="col">ช่องทางชำระเงิน</th>
                <th scope="col">สถานะ</th>
                <th scope="col">รายละเอียด</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();
            $user_id = $_SESSION['userid'];
            $sql = "SELECT orders.order_id,
                   GROUP_CONCAT(order_detail.pd_name SEPARATOR ', ') AS products,
                   orders.total,
                   orders.payment,
                   orders.order_status
            FROM orders
            INNER JOIN order_detail ON orders.order_id = order_detail.order_id
            WHERE orders.user_id = '$user_id'
            GROUP BY orders.order_id
            ORDER BY orders.order_id";

            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?= $row['order_id'] ?></td>
                    <td>
                        <?php
                        $productList = explode(', ', $row['products']);
                        // Define how many products you want to display
                        $maxProductsToShow = 3;

                        if (count($productList) > $maxProductsToShow) {
                            // Display the first few products followed by an ellipsis
                            echo implode(', ', array_slice($productList, 0, $maxProductsToShow)) . '...';
                        } else {
                            // Display all products if there are not many
                            echo $row['products'];
                        }
                        ?>
                    </td>

                    <td><?= number_format($row['total'], 2) ?></td>
                    <td><?= $row['payment'] ?></td>
                    <td>
                        <span class="badge 
                            <?php
                            if ($row['order_status'] == 'waiting') {
                                echo 'bg-warning';
                            } elseif ($row['order_status'] == 'shipped') {
                                echo 'bg-success';
                            } elseif ($row['order_status'] == 'canceled') {
                                echo 'bg-danger';
                            }
                            ?>">
                            <?= $row['order_status'] ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" title="View Details" onclick="order_detail('<?=$row['order_id'] ?>')">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>