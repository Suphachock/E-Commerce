<?php
// Include the database connection file
include('../condb.php');

// Fetch the data from the POST request
$id = $_POST['id'];
$username = $_POST['username'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$tel = $_POST['tel'];
// Convert the admin checkbox value to integer (0 for false, 1 for true)
$admin = isset($_POST['admin']) ? 1 : 0;


// Prepare the SQL query to update data in the member table
$sql = "UPDATE member SET username = ?, fullname = ?, email = ?, tel = ?, isAdmin = ? WHERE id = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check if statement preparation was successful
if ($stmt) {
    // Bind parameters (username, password, fullname, email, telephone, isAdmin, id)
    $stmt->bind_param('sssssi', $username, $fullname, $email, $tel, $admin, $id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "error: Could not prepare statement";
}

// Close the database connection
$conn->close();
?>
