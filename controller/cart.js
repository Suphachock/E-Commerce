$(document).ready(function () {
  cart_number();
});

function addCart(id) {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/model/add_cart.php",
    data: {
      id: id,
    },
    success: function () {
      cart_number();
      Toastify({
        text: "เพิ่มสินค้าในตะกร้าแล้ว",
        duration: 1200,
        destination: "",
        newWindow: false,
        close: false,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () {}, // Callback after click
      }).showToast();
    },
  });
}
function deleteCart(id) {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/model/delete_cart.php",
    data: {
      id: id,
    },
    success: function () {
      cart_number();
      display_cart_data();
      Toastify({
        text: "ลบสินค้าในตะกร้าแล้ว",
        duration: 1200,
        destination: "",
        newWindow: false,
        close: false,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
          background: "linear-gradient(to right, #f44336, #f48236)",
        },
        onClick: function () {}, // Callback after click
      }).showToast();
    },
  });
}
function cart_number() {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/model/count_cart.php",
    dataType: "html",
    success: function (res) {
      $("#cart_number").html(res);
    },
  });
}

function updateCartQty(productId, newQty) {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/model/update_cart.php",
    data: {
      productId: productId,
      newQty: newQty,
    },
    success: function () {
      cart_number();
      display_cart_data();
      Toastify({
        text: "อัพเดทสินค้าในตะกร้าแล้ว",
        duration: 1200,
        destination: "",
        newWindow: false,
        close: false,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () {}, // Callback after click
      }).showToast();
    },
  });
}
