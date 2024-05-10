<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/E-Commerce">Book-Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <?php
        if (isset($_SESSION['userid'])) { ?>
          <li class="nav-item">
            <a class="nav-link active"><i class="fa-solid fa-user"></i> สวัสดีคุณ <?= htmlspecialchars($_SESSION['fullname']) ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/E-Commerce/view/checkout.php" id="cart_number">
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/E-Commerce/view/order.php"><i class="fa-solid fa-truck-fast"></i> ติดตามคำสั่งซื้อ</a> <!-- Replace the link with the correct path -->
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#" onclick="logout()"><i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ</a> 
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link active" href="/E-Commerce/view/login.php"><i class="fa-solid fa-right-to-bracket"></i> เข้าสู่ระบบ</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
