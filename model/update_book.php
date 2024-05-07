<?php
// Include the database connection file
include('../condb.php');

// Fetch the data from the POST request
$book_id = $_POST['book_id'];
$book_name = $_POST['book_name'];
$book_price = $_POST['book_price'];
$book_qty = $_POST['book_qty'];
$book_detail = $_POST['book_detail'];
$book_img = $_FILES['book_img'];

// Fetch the current image path from the database
$sql = "SELECT pd_image FROM product WHERE pd_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $book_id);
$stmt->execute();
$stmt->bind_result($current_img_path);
$stmt->fetch();
$stmt->close();

// Check if an image file was uploaded
if ($book_img['size'] > 0) {
    // Generate a unique file name for the new image
    $unique_file_name = uniqid() . "_" . basename($book_img['name']);
    $target_dir = "../img/";
    $target_file = $target_dir . $unique_file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($book_img['tmp_name'], $target_file)) {
        // Delete the old image file
        if (file_exists($current_img_path)) {
            unlink($current_img_path);
        }

        // Update the database with the new image path and other details
        $sql = "UPDATE product SET pd_name = ?, pd_price = ?, pd_qty = ?, pd_detail = ?, pd_image = ? WHERE pd_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdisss', $book_name, $book_price, $book_qty, $book_detail, $target_file, $book_id);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit;
    }
} else {
    // No new image file was uploaded; update other details only
    $sql = "UPDATE product SET pd_name = ?, pd_price = ?, pd_qty = ?, pd_detail = ? WHERE pd_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdiss', $book_name, $book_price, $book_qty, $book_detail, $book_id);
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
?>
