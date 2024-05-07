<?php
// Include the database connection file
include('../condb.php');

// Fetch the data from the POST request
$book_name = $_POST['book_name'];
$book_price = $_POST['book_price'];
$book_qty = $_POST['book_qty'];
$book_detail = $_POST['book_detail'];
$book_img = $_FILES['book_img'];

// Check if an image file was uploaded
if ($book_img['size'] > 0) {
    // Generate a unique file name for the new image
    $unique_file_name = uniqid() . "_" . basename($book_img['name']);
    $target_dir = "../img/";
    $target_file = $target_dir . $unique_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($book_img['tmp_name'], $target_file)) {
        // SQL query for inserting a new record into the 'product' table
        $sql = "INSERT INTO product (pd_name, pd_price, pd_qty, pd_detail, pd_image) VALUES (?, ?, ?, ?, ?)";
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        // Bind parameters (book name, book price, book quantity, book detail, image path)
        $stmt->bind_param('sdiss', $book_name, $book_price, $book_qty, $book_detail, $target_file);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit;
    }
}

// Execute the query
if ($stmt->execute()) {
    // The update was successful
    echo "success";
}

// Close the prepared statement
$stmt->close();
// Close the database connection
$conn->close();
