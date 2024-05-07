<?php
// Include the database connection
include_once "../condb.php";

// Retrieve the member ID from the POST request
$id = isset($_POST['id']) ? intval($_POST['id']) : null;

// Fetch member data from the database using a prepared statement
$stmt = $conn->prepare("SELECT * FROM member WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if data was retrieved
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Handle error case (e.g., member not found)
    echo "<p>Member not found.</p>";
    exit;
}

// Close the statement
$stmt->close();
?>

<!-- Modal for editing member information -->
<div class="modal" tabindex="-1" id="md_member_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูลสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_member" method="POST">
                <div class="modal-body">
                    <!-- Hidden field for member ID -->
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">

                    <!-- Username -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="username" class="form-label">Username</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="username" id="username" value="<?= htmlspecialchars($row['username']) ?>" required>
                        </div>
                    </div>

                    <!-- Fullname -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="fullname" class="form-label">Fullname</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="fullname" id="fullname" value="<?= htmlspecialchars($row['fullname']) ?>" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="email" class="form-label">Email</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($row['email']) ?>" required>
                        </div>
                    </div>

                    <!-- Telephone -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tel" class="form-label">Telephone</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="tel" id="tel" value="<?= htmlspecialchars($row['tel']) ?>" maxlength="10" required>
                        </div>
                        <div class="col-md-3">
                            <!-- Admin Checkbox -->
                            <label for="admin" class="form-check-label">Admin</label>
                            <input type="checkbox" class="form-check-input" name="admin" id="admin" value="1" <?= $row['isAdmin'] == 1 ? 'checked' : '' ?>>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#edit_member').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '../model/update_member.php', // The URL of your PHP script
                type: 'POST', // The HTTP method to use (POST)
                data: formData, // The form data
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting a default content type
                success: function(res) {
                    if (res === "success") {
                        alert("Update Member Success!!")
                        $("#md_member_edit").modal('hide');
                        $.ajax({
                            type: "POST",
                            url: "member_table.php",
                            dataType: "html",
                            success: function(res) {
                                $(".member_table").html(res);
                            }
                        });
                    } else {
                        alert("Failed to update member!")
                    }
                }
            });
        });
    });
</script>