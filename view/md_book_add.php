<div class="modal" tabindex="-1" id="md_book_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มหนังสือ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_book" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_name" class="form-label">ชื่อหนังสือ</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="book_name" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_price" class="form-label">ราคา(บาท)</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="book_price" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_qty" class="form-label">จำนวน(เล่ม)</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="book_qty" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_detail" class="form-label">รายละเอียด</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" name="book_detail"></textarea>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <label for="book_img" class="form-label">รูปหนังสือ</label>
                            </div>
                            <div class="col-md-9">
                                <input type="file" name="book_img" class="form-control mt-3" accept="image/*" onchange="previewImage(event)" required>
                                <!-- Image preview element -->
                                <img id="image_preview" class="mt-3" src="" alt="Image preview" style="max-width: 100px; display: none;">
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
        $('#add_book').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: 'model/add_book.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    if (res === "success") {
                        alert("Add Book Success!!")
                        $("#md_book_add").modal('hide');
                        $.ajax({
                            type: "POST",
                            url: "view/book_table.php",
                            dataType: "html",
                            success: function(res) {
                                $(".book-table").html(res);
                            }
                        });
                    } else {
                        alert("Failed to add book!")
                    }
                }
            });
        });
    });

    function previewImage(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            const imagePreview = document.getElementById('image_preview');

            // This function runs when the FileReader has finished loading the file
            reader.onload = function(event) {
                // Update the src attribute of the image preview
                imagePreview.src = event.target.result;
                // Make the image preview visible
                imagePreview.style.display = 'block';
            };

            // Read the file as a Data URL (base64 encoded string)
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, hide the image preview
            document.getElementById('image_preview').style.display = 'none';
            document.getElementById('image_preview').src = '';
        }
    }
</script>