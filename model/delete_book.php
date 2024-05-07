<?php
include('../condb.php');

// Assuming that 'id' is an integer, you may need to validate and sanitize it.
$id = $_POST['id'];

// Use a prepared statement to prevent SQL injection
$sql = "DELETE FROM product WHERE pd_id = ?";
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("i", $id);

// Execute the statement
if ($stmt->execute()) {
    echo "success";
}

// Close the statement and connection
$stmt->close();
$conn->close();
