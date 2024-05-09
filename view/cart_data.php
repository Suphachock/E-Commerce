<?php
// Start the session
session_start();

// Include the database connection file
include_once "../condb.php";

// Get the user information based on the username in the session
if (isset($_SESSION['username'])) {
    $sql = "SELECT * FROM member WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['username']);
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
                foreach ($_SESSION['cart'] as $pd_id => $quantity) {
                    $total_qty += $quantity;

                    // Find the product information from $result_cart
                    foreach ($result_cart as $row_cart) {
                        if ($row_cart['pd_id'] == $pd_id) {
                            $cart_qty = $_SESSION['cart'][$pd_id];
                            $total_price += $row_cart['pd_price'] * $cart_qty;
                            break;
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
                    // Reset the result_cart data pointer
                    $result_cart->data_seek(0);

                    // Iterate through each product in the cart and display it
                    while ($row_cart = $result_cart->fetch_assoc()) {
                        $cart_qty = $_SESSION['cart'][$row_cart['pd_id']];
                    ?>
                        <li class="list-group-item d-flex align-items-center">

                            <!-- Image -->
                            <img src="../img/<?= $row_cart['pd_image'] ?>" alt="<?= $row_cart['pd_name'] ?>" width="60" class="mr-3 rounded" style="object-fit: cover; border-radius: 8px;">

                            <!-- Main content -->
                            <div class="d-flex justify-content-between flex-grow-1 mx-1">
                                <div class="d-flex flex-column">
                                    <h6 class="my-0 font-weight-bold"><?= $row_cart['pd_name'] ?></h6>
                                    <span class="text font-weight-bold">฿<?= number_format($row_cart['pd_price'], 2) ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="number" class="form-control mx-1" min="1" max="100" value="<?= $cart_qty ?>" style="width: 60px;" onchange="updateCartQty('<?= $row_cart['pd_id'] ?>', this.value)">
                                    <button class="btn btn-danger" onclick="deleteCart('<?= $row_cart['pd_id'] ?>')">
                                        <i class="fa-solid fa-trash fa-2xs"></i> ลบ
                                    </button>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>ราคารวม (บาท)</span>
                        <strong>฿<?= $total_price ?></strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">รายละเอียดคำสั่งซื้อ</h4>

                <form novalidate>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="fullName" class="form-label">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" id="fullName" placeholder="" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                            <div class="invalid-feedback">
                                Valid name is required.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                        </div>

                        <div class="col-12">
                            <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['tel']) ?>" readonly>
                        </div>

                        <div class="col-6">
                            <label for="address" class="form-label">ที่อยู่</label>
                            <textarea class="form-control" readonly><?= htmlspecialchars($user['address']) ?></textarea>
                        </div>

                        <div class="col-6">
                            <h4 class="mb-3 mx-3">ช่องทางชำระเงิน</h4>

                            <div class="my-3 d-flex">
                                <div class="form-check mx-2">
                                    <input name="paymentMethod" type="radio" class="form-check-input" checked>
                                    <label class="form-check-label" for="credit">เก็บเงินปลายทาง</label>
                                </div>
                                <div class="form-check mx-2">
                                    <input type="radio" class="form-check-input" disabled>
                                    <label class="form-check-label" for="debit">บัตรเครดิต</label>
                                </div>
                                <div class="form-check mx-2">
                                    <input type="radio" class="form-check-input" disabled>
                                    <label class="form-check-label" for="paypal">แอพธนาคาร</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">ยืนยันคำสั่งซื้อ</button>
                </form>
            </div>
        </div>
    </main>
<?php else : ?>
    <div class="d-flex justify-content-center align-items-center">
        <h1>ไม่มีสินค้าในตะกร้า...</h1>
    </div>
<?php endif; ?>