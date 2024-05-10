document.addEventListener("DOMContentLoaded", function () {
  // สมัครสมาชิก
  $("#register").on("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(this);
    $.ajax({
      url: "../model/add_member.php", // The URL of your PHP script
      type: "POST", // The HTTP method to use (POST)
      data: formData, // The form data
      processData: false, // Prevent jQuery from processing the data
      contentType: false, // Prevent jQuery from setting a default content type
      success: function (res) {
        if (res === "success") {
          alert("Add Member Success!!");
          window.location.replace("/E-Commerce/view/login.php");
        } else {
          alert(res);
        }
      },
    });
  });

  // Attach a submit event handler to the login form
  $("#login").on("submit", function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    // Create a FormData object from the form
    const formData = new FormData(this);
    // Send an AJAX request to the server
    $.ajax({
      url: "../model/login_check.php", // The URL of your PHP script
      type: "POST", // Use the POST method to submit the data
      data: formData, // The form data to be sent
      processData: false, // Prevent jQuery from processing the data
      contentType: false, // Prevent jQuery from setting a default content type
      success: function (response) {
        if (response ==="Login success.") {
          window.location.reload();
        } else {
          alert(response);
        }
      },
    });
  });
});

function logout() {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/model/logout.php",
    success: function () {
      window.location.reload();
    },
  });
}
