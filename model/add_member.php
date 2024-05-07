<?php
// Include the database connection file
include('../condb.php');

// Fetch the data from the POST request
$username = $_POST['username'];
$password = $_POST['password'];
$fullname = $_POST['fullname']; // Make sure you have a fullname field in your form
$email = $_POST['email'];
$tel = $_POST['tel'];
// Convert the admin checkbox value to integer (0 for false, 1 for true)
$admin = isset($_POST['admin']) ? 1 : 0;

// Hash the password for secure storage
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL query to insert data into the member table
$sql = "INSERT INTO member (username, password, fullname, email, tel, isAdmin) VALUES (?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check if statement preparation was successful
if ($stmt) {
    // Bind parameters (username, password, fullname, email, telephone, isAdmin)
    $stmt->bind_param('sssssi', $username, $hashedPassword, $fullname, $email, $tel, $admin);

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
