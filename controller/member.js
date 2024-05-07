function show_md_member_add() {
  $.ajax({
    type: "POST",
    url: "md_member_add.php",
    dataType: "html",
    success: function (res) {
      $(".md_member_add").html(res);
      $("#md_member_add").modal("show");
    },
  });
}

function editMember(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_member_edit.php",
    data: {
      id: id,
    },
    dataType: "html",
    success: function (res) {
      $(".md_member_edit").html(res);
      $("#md_member_edit").modal("show");
    },
  });
}

function deleteMember(id) {
  $.ajax({
    type: "POST",
    url: "../model/delete_member.php",
    data: {
      id: id,
    },
    dataType: "html",
    success: function (res) {
      if (res.trim() === "success") {
        alert("Delete member success!!!");
        $.ajax({
          type: "POST",
          url: "../view/member_table.php",
          dataType: "html",
          success: function (res) {
            $(".member_table").html(res);
          },
        });
      }
    },
  });
}
