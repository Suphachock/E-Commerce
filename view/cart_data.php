<?php
// Start the session
session_start();

// Include the database connection file
include_once "../condb.php";

// Get the user information based on the username in the session
if (isset($_SESSION['userid'])) {
    $sql = "SELECT fullname,tel,address,email FROM member WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['userid']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ensure result is valid
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
    $stmt->close();
}

// Retrieve products from the cart
$product_ids = array_keys($_SESSION['cart'] ?? []); // Null coalescing to prevent warning

if (!empty($product_ids)) {
    // Prepare the query with an IN clause for product IDs
    $sql_cart = "SELECT * FROM product WHERE pd_id IN (" . implode(',', array_fill(0, count($product_ids), '?')) . ")";
    $stmt_cart = $conn->prepare($sql_cart);
    $stmt_cart->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
    $stmt_cart->execute();
    $result_cart = $stmt_cart->get_result();
} else {
    // Initialize $result_cart to an empty array when there are no product IDs
    $result_cart = [];
}

?>

<!-- Check if there are items in the cart -->
<?php if ($result_cart && $result_cart->num_rows > 0) : ?>
    <main>
        <div class="row g-5 mt-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <?php
                // Calculate the total quantity and total price
                $total_qty = 0;
                $total_price = 0;

                // Iterate through each product in the cart
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $pd_id => $quantity) {
                        $total_qty += $quantity;

                        // Iterate through $result_cart to find the product
                        if ($result_cart !== null) {
                            while ($row_cart = $result_cart->fetch_assoc()) {
                                if ($row_cart['pd_id'] == $pd_id) {
                                    $cart_qty = $_SESSION['cart'][$pd_id];
                                    $total_price += $row_cart['pd_price'] * $cart_qty;
                                    break;
                                }
                            }
                        }
                    }
                }
                ?>
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">สินค้าของคุณ</span>
                    <span class="badge bg-primary rounded-pill"><?= $total_qty ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php
                    // Reset result_cart data pointer
                    if ($result_cart !== null) {
                        $result_cart->data_seek(0);

                        // Iterate through each product in the cart and display it
                        while ($row_cart = $result_cart->fetch_assoc()) {
                            $cart_qty = isset($_SESSION['cart'][$row_cart['pd_id']]) ? $_SESSION['cart'][$row_cart['pd_id']] : 0;
                    ?>
                            <li class="list-group-item d-flex align-items-center">
                                <!-- Image -->
                                <img src="../img/<?= htmlspecialchars($row_cart['pd_image']) ?>" alt="<?= htmlspecialchars($row_cart['pd_name']) ?>" width="60" class="mr-3 rounded" style="object-fit: cover; border-radius: 8px;">

                                <!-- Main content -->
                                <div class="d-flex justify-content-between flex-grow-1 mx-2">
                                    <div class="d-flex flex-column">
                                        <h6 class="my-0 font-weight-bold"><?= htmlspecialchars($row_cart['pd_name']) ?></h6>
                                        <!-- Add margin-top to span to add space between h6 and span -->
                                        <span class="text font-weight-bold" style="margin-top: 10px;">฿<?= number_format($row_cart['pd_price'], 2) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input type="number" name="qty" class="form-control mx-1" min="1" max="100" value="<?= $cart_qty ?>" style="width: 60px;" onchange="updateCartQty('<?= $row_cart['pd_id'] ?>', this.value)">
                                        <a class="btn btn-danger mx-1" onclick="deleteCart('<?= $row_cart['pd_id'] ?>')">
                                            <i class="fa-solid fa-trash fa-2xs"></i> ลบ
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <input type="hidden" name="pd_id[]" value="<?= $row_cart['pd_id'] ?>">
                            <input type="hidden" name="pd_name[]" value="<?= htmlspecialchars($row_cart['pd_name']) ?>">
                            <input type="hidden" name="pd_price[]" value=" <?= number_format($row_cart['pd_price'], 2) ?>">
                    <?php
                        }
                    }
                    ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>ราคารวม (บาท)</span>
                        <strong>฿<?= number_format($total_price, 2) ?></strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">รายละเอียดคำสั่งซื้อ</h4>
                <div class="row g-3">
                    <div class="col-sm-12">
                        <label for="fullName" class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                        <div class="invalid-feedback">
                            Valid name is required.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                    </div>

                    <div class="col-12">
                        <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" name="tel" class="form-control" value="<?= htmlspecialchars($user['tel']) ?>" readonly>
                    </div>

                    <div class="col-6">
                        <label for="address" class="form-label">ที่อยู่</label>
                        <textarea name="address" class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>
                    </div>

                    <div class="col-6">
                        <h4 class="mb-3 mx-3">ช่องทางชำระเงิน</h4>

                        <div class="my-3 d-flex">
                            <div class="form-check mx-2">
                                <input name="payment" value="เก็บเงินปลายทาง" type="radio" class="form-check-input" checked>
                                <label class="form-check-label">เก็บเงินปลายทาง</label>
                            </div>
                            <div class="form-check mx-2">
                                <input name="payment" type="radio" class="form-check-input" disabled>
                                <label class="form-check-label">บัตรเครดิต</label>
                            </div>
                            <div class="form-check mx-2">
                                <input name="payment" type="radio" class="form-check-input" disabled>
                                <label class="form-check-label">แอพธนาคาร</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">ยืนยันคำสั่งซื้อ</button>

                <!-- เก็บตัวแปร -->
                <input type="hidden" name="total" value="<?= $total_price ?>">
                <input type="hidden" name="order_status" value="waiting">


            </div>
        </div>
    </main>
<?php else : ?>
    <div class="mt-5">
        <h1>ไม่มีสินค้าในตะกร้า...</h1>
    </div>
<?php endif; ?>