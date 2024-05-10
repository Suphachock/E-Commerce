<?php
// Start the session
session_start();

// Include the database connection file
include_once "../condb.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment'];
    $total_price = $_POST['total'];
    $order_status = $_POST['order_status'] ?? 'waiting';
    $user_id = $_SESSION['userid'];


    // Validate the form data
    if (empty($fullname) || empty($email) || empty($tel) || empty($address) || empty($payment_method) || empty($user_id) || empty($total_price)) {
        die("All fields are required.");
    }

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Insert order data into 'orders' table
        $order_sql = "INSERT INTO orders (user_id, order_status, total, payment, order_date) 
                      VALUES (?, ?, ?, ?, NOW())";
        $stmt_order = $conn->prepare($order_sql);
        $stmt_order->bind_param("isds", $user_id, $order_status, $total_price, $payment_method);
        $stmt_order->execute();

        // Retrieve the last inserted order ID
        $lastOrderId = $stmt_order->insert_id;

        // Insert order details into 'order_detail' table
        $order_detail_sql = "INSERT INTO order_detail (order_id, pd_name, pd_price, pd_qty,pd_id) 
                             VALUES (?, ?, ?, ?,?)";
        $stmt_detail = $conn->prepare($order_detail_sql);

        foreach ($_SESSION['cart'] as $productId => $productQty) {
            // Bind data and execute the statement
            $index = array_search($productId, array_keys($_SESSION['cart']));
            $pd_name = $_POST['pd_name'][$index];
            $pd_price = $_POST['pd_price'][$index];
            $pd_id = $_POST['pd_id'][$index];

            $stmt_detail->bind_param("isdii", $lastOrderId, $pd_name, $pd_price, $productQty, $pd_id);
            $stmt_detail->execute();
        }

        // Commit the transaction
        $conn->commit();
        echo "Order placed successfully.";

        // Clear the cart after successful order placement
        unset($_SESSION['cart']);
    } catch (Exception $e) {
        // Roll back the transaction in case of an error
        $conn->rollBack();
        echo "Error placing order: " . $e->getMessage();
    } finally {
        // Close the statements
        $stmt_order->close();
        $stmt_detail->close();
    }
}

// Close the database connection
$conn->close();
