<?php
// Include the database connection file
include('../condb.php');

// Fetch the data from the POST request
$id = isset($_POST['id']) ? intval($_POST['id']) : null;

// Ensure `id` was provided
if ($id === null) {
    echo "error: Invalid ID provided.";
    exit;
}

// Prepare the SQL query to delete data from the member table
$sql = "DELETE FROM member WHERE id = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check if statement preparation was successful
if ($stmt) {
    // Bind parameters (`id` only)
    $stmt->bind_param('i', $id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "error: Could not prepare statement.";
}

// Close the database connection
$conn->close();
?>
