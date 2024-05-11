<?php
// Include the database connection file
include('../condb.php');

// Fetch the data from the POST request
$id = $_POST['id'];

// Prepare the SQL query to update data in the member table
$sql = "UPDATE orders SET order_status = 'shipped' WHERE order_id = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check if statement preparation was successful
if ($stmt) {
    // Bind parameters (username, password, fullname, email, telephone, isAdmin, id)
    $stmt->bind_param('i', $id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "Update success";
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
