<?php
include_once '../condb.php';

if (isset($_POST['id'])) {
    $orderId = $_POST['id'];

    // Update the SQL query to join with the orders table and retrieve multiple rows
    $sql = "SELECT od.pd_qty, od.pd_price, od.pd_name, o.total , pd.pd_image
            FROM order_detail od
            JOIN orders o ON od.order_id = o.order_id
            JOIN product pd ON od.pd_id = pd.pd_id
            WHERE od.order_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch all rows and store them in an array
        $orderItems = $result->fetch_all(MYSQLI_ASSOC);
        // We assume that the total remains consistent across all rows since it belongs to the order
        $orderTotal = $orderItems[0]['total'];
    } else {
        die("Order not found!");
    }

    $stmt->close();
}
?>

<div class="modal" tabindex="-1" id="order_detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดออเดอร์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="">
                <div class="modal-body">
                    <div class="modal-body">
                        <ul class="list-group mb-3">
                            <?php foreach ($orderItems as $item) : ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <img src="../img/<?= htmlspecialchars($item['pd_image']) ?>" alt="<?= htmlspecialchars($row_cart['pd_name']) ?>" width="60" class="mr-3 rounded" style="object-fit: cover; border-radius: 8px;">

                                    <!-- Main content -->
                                    <div class="d-flex justify-content-between flex-grow-1 mx-2">
                                        <div class="d-flex flex-column">
                                            <h6 class="my-0 font-weight-bold"><?= htmlspecialchars($item['pd_name']) ?></h6>
                                            <span class="text font-weight-bold" style="margin-top: 10px;">฿<?= number_format($item['pd_price'], 2) ?></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <h6><?= $item['pd_qty'] ?> เล่ม</h6>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>ราคารวม (บาท)</span>
                                <strong>฿<?= number_format($orderTotal, 2) ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>