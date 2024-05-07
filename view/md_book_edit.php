<?php
include_once "../condb.php";
$id = $_POST['id'];
$sql = "SELECT * FROM product WHERE pd_id = $id";
$result = $conn->query($sql);
if ($result) {
    foreach ($result as $row) {
    }
}
?>

<div class="modal" tabindex="-1" id="md_book_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดหนังสือ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="md_book" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="hidden" name="book_id" value="<?= $id ?>">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_name" class="form-label">ชื่อหนังสือ</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['pd_name']) ?>" name="book_name" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_price" class="form-label">ราคา(บาท)</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" value="<?= htmlspecialchars($row['pd_price']) ?>" name="book_price" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_qty" class="form-label">จำนวน(เล่ม)</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" value="<?= htmlspecialchars($row['pd_qty']) ?>" name="book_qty" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_detail" class="form-label">รายละเอียด</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" name="book_detail"><?= htmlspecialchars($row['pd_detail']) ?></textarea>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="" class="form-label">รูปหนังสือ</label>
                            </div>
                            <div class="col-md-9">
                                <img src="img/<?= htmlspecialchars($row['pd_image']) ?>" width="100px" alt="Book Image">
                                <input type="file" name="book_img" class="form-control mt-3" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#md_book').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'model/update_book.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type

                success: function(res) {
                    if (res === "success") {
                        alert("Update Book Success!!")
                        $("#md_book_edit").modal('hide');
                        $.ajax({
                            type: "POST",
                            url: "view/book_table.php",
                            dataType: "html",
                            success: function(res) {
                                $(".book-table").html(res);
                            }
                        });
                    } else {
                        alert("Failed to update book!")
                    }
                }
            });
        });
    });
</script>