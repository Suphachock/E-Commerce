<?php
session_start();
include('../condb.php');

// Fetch the data from the POST request
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Prepare the SQL query to retrieve data from the member table
$sql = "SELECT id,password,isAdmin FROM member WHERE username = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters (username)
    $stmt->bind_param('s', $username);

    // Execute the query
    if ($stmt->execute()) {
        // Fetch the result
        $stmt->store_result();

        // Check if there is a user with the provided username
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($id, $dbPassword, $isAdmin);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $dbPassword)) {
                // Create session variables
                $_SESSION['userid'] = $id;  // Store username in session
                echo "Login success.";
            } else {
                // Password does not match
                echo "Username or password incorrect.";
            }
        } else {
            // No user found with the provided username
            echo "Username or password incorrect.";
        }
    } else {
        // Failed to execute query
        echo "Error executing query.";
    }

    // Close the statement
    $stmt->close();
} else {
    // Failed to prepare statement
    echo "Error preparing query.";
}

// Close the database connection
$conn->close();
