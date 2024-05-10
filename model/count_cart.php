<?php
session_start();
if(isset($_SESSION['cart'])){
    echo '<i class="fa-solid fa-cart-shopping"></i> ตะกร้า' . (count($_SESSION['cart']) ? " (" . count($_SESSION['cart']) . ")" : "");
}
else{
    echo '<i class="fa-solid fa-cart-shopping"></i> ตะกร้า';
}
