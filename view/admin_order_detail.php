<?php
include_once '../condb.php';

if (isset($_POST['id'])) {
    $orderId = $_POST['id'];

    // Update the SQL query to join with the orders table and retrieve multiple rows
    $sql = "SELECT od.pd_qty, od.pd_price, od.pd_name, o.total , pd.pd_image,m.fullname,m.tel,m.address,o.payment,od.order_id,o.order_status
            FROM order_detail AS od
            JOIN orders o ON od.order_id = o.order_id
            JOIN product pd ON od.pd_id = pd.pd_id
            JOIN member m ON o.user_id = m.id
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

<div class="modal modal-xl" tabindex="-1" id="order_detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดออเดอร์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Order Details -->
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                รายละเอียดสินค้า
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($orderItems as $item) : ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <!-- Product Image -->
                                        <img src="../img/<?= htmlspecialchars($item['pd_image']) ?>" alt="<?= htmlspecialchars($item['pd_name']) ?>" width="60" class="rounded me-3" style="object-fit: cover; border-radius: 8px;">

                                        <!-- Main Content -->
                                        <div class="d-flex justify-content-between flex-grow-1">
                                            <!-- Product Info -->
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?= htmlspecialchars($item['pd_name']) ?></h6>
                                                <small class="text-muted">฿<?= number_format($item['pd_price'], 2) ?></small>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="text-end">
                                                <h6 class="mb-0"><?= $item['pd_qty'] ?> เล่ม</h6>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Order Total -->
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between">
                                    <span>ราคารวม (บาท)</span>
                                    <strong>฿<?= number_format($orderTotal, 2) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="col-lg-5">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                ข้อมูลลูกค้า
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">ชื่อ-นามสกุล</label>
                                    <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($item['fullname']) ?>" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($item['tel']) ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">ที่อยู่</label>
                                    <textarea name="address" class="form-control" disabled><?= htmlspecialchars($item['address']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="payment" class="form-label">ช่องทางชำระเงิน</label>
                                    <input type="text" name="payment" class="form-control" value="<?= htmlspecialchars($item['payment']) ?>" disabled>
                                </div>
                                <?php if ($item['order_status'] != 'shipped') { ?>
                                    <div class="mb-3">
                                        <div class="row text-center mt-5">
                                            <div class="col">
                                                <button class="btn btn-danger btn-lg" onclick="admin_order_cancel('<?= $item['order_id'] ?>')"><i class="fa-solid fa-ban"></i> Cancel</button>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-success btn-lg" onclick="admin_order_confirm('<?= $item['order_id'] ?>')"><i class="fa-solid fa-check"></i> Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>