<div class="modal" tabindex="-1" id="md_member_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_member" method="POST">
                <div class="modal-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="username" class="form-label">Username</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="password" class="form-label">Password</label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="fullname" class="form-label">Fullname</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="fullname" id="fullname" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="email" class="form-label">Email</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tel" class="form-label">Telephone</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="tel" id="tel" maxlength="4" required>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="admin" id="admin" value="1">
                                <label class="form-check-label" for="admin">
                                    Admin
                                </label>
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
</div>
</div>


<script>
    $(document).ready(function() {
        $('#add_member').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '../model/add_member.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    if (res === "success") {
                        alert("Add Member Success!!")
                        $("#md_member_add").modal('hide');
                        $.ajax({
                            type: "POST",
                            url: "member_table.php",
                            dataType: "html",
                            success: function(res) {
                                $(".member_table").html(res);
                            }
                        });
                    } else {
                        alert("Failed to add member!")
                    }
                }
            });
        });
    });
</script>