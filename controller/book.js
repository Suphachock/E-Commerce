function show_md_book_edit(id) {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/view/md_book_edit.php",
    data: {
      id: id,
    },
    dataType: "html",
    success: function (res) {
      $(".md_book_edit").html(res);
      $("#md_book_edit").modal("show");
    },
  });
}

function show_md_book_add() {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/view/md_book_add.php",
    dataType: "html",
    success: function (res) {
      $(".md_book_add").html(res);
      $("#md_book_add").modal("show");
    },
  });
}

function delete_book(id) {
  $.ajax({
    type: "POST",
    url: "/E-Commerce/model/delete_book.php",
    data: {
      id: id,
    },
    success: function (res) {
      alert("Delete book success!!!");
      $.ajax({
        type: "POST",
        url: "/E-Commerce/view/book_table.php",
        dataType: "html",
        success: function (res) {
          $(".book-table").html(res);
        },
      });
    },
  });
}
