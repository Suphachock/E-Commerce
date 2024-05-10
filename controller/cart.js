document.addEventListener("DOMContentLoaded", function () {
  cart_number();

});

function addCart(id) {
  // Send a POST request to the add_cart.php script
  fetch("/E-Commerce/model/add_cart.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${encodeURIComponent(id)}`, // Send the id as a URL-encoded parameter
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      // Call the function to update cart number
      cart_number();
      // Show a notification that the item was added to the cart
      Toastify({
        text: "เพิ่มสินค้าในตะกร้าแล้ว",
        duration: 1200,
        gravity: "top",
        position: "right",
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
      }).showToast();
    })
    .catch((error) => {
      console.error("Fetch error:", error);
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
          background: "linear-gradient(to right, #0a53be, #0a86be)",
        },
        onClick: function () {}, // Callback after click
      }).showToast();
    },
  });
}
