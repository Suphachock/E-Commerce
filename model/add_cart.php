<?php
session_start();
include_once "../condb.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Initialize cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update item quantity in the cart
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += 1;
        echo "Add book to cart success!";
    } else {
        $_SESSION['cart'][$id] = 1;
        echo "Add book to cart success!";
    }
} else {
    echo "Book id is not found!";
}
