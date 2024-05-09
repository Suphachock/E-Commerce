<?php
session_start();
include_once "../condb.php";

// Get the product ID and new quantity from the request data
$productId = $_POST['productId'];
$newQty = $_POST['newQty'];

// Update the session cart
if ($newQty > 0) {
    $_SESSION['cart'][$productId] = $newQty;
} else {
    // Remove the product from the cart if the quantity is zero or negative
    unset($_SESSION['cart'][$productId]);
}
