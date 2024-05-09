<?php
session_start();
include_once "../condb.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    } else {
        echo "Item with ID $id not found in cart!";
    }
} else {
    echo "Cart ID is not found!";
}
