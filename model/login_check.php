<?php
session_start();
include('../condb.php');

// Fetch the data from the POST request
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Prepare the SQL query to retrieve data from the member table
$sql = "SELECT password, isAdmin,fullname FROM member WHERE username = ?";

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
            $stmt->bind_result($dbPassword, $isAdmin,$fullname);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $dbPassword)) {
                // Create session variables
                $_SESSION['username'] = $username;  // Store username in session
                $_SESSION['admin'] = $isAdmin;  // Store admin status in session
                $_SESSION['fullname'] = $fullname;  // Store admin status in session

               echo $isAdmin;
            } else {
                // Password does not match
                echo "Incorrect password.";
            }
        } else {
            // No user found with the provided username
            echo "Username not found.";
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
