<?php
// Start the session
session_start();

// Check if the user is logged in and their admin status
if (isset($_SESSION['username'])) {
    // Check if user is an admin
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        // Redirect to admin index page
        header("Location: /E-Commerce/admin_index.php");
        exit();
    }
    // Check if user is not an admin
    elseif (isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
        // Redirect to the home page
        header("Location: /E-Commerce/");
        exit();
    }
}

// Includes database connection and navbar
include_once "../condb.php";
include_once "../navbar.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body class="bg-light">
    <div class="container mt-5 h-75 d-flex justify-content-center align-items-center">
    
        <div class="card " style="width: 400px;">
            <ul class="nav nav-tabs card-header" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="login-tab-pane" aria-selected="true">Login</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-tab-pane" type="button" role="tab" aria-controls="register-tab-pane" aria-selected="false">Register</button>
                </li>
            </ul>

            <div class="card-body tab-content" id="myTabContent">
                <!-- Login Form -->
                <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab">
                    <form id="login">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" placeholder="name@example.com">
                            <label for="login-username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="w-100 btn btn-lg btn-primary">Login</button>
                        </div>
                    </form>
                </div>

                <!-- Register Form -->
                <div class="tab-pane fade" id="register-tab-pane" role="tabpanel" aria-labelledby="register-tab">
                    <form id="register">
                        <div class="form-floating  mb-3">
                            <input type="text" class="form-control" name="username" id="username" required>
                            <label for="register-username">Username</label>
                        </div>
                        <div class="form-floating  mb-3">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <label for="register-password">Password</label>
                        </div>
                        <div class="form-floating  mb-3">
                            <input type="text" class="form-control" name="fullname" id="fullname" required>
                            <label for="register-fullname">Full Name</label>

                        </div>
                        <div class="form-floating  mb-3">
                            <input type="email" class="form-control" name="email" id="email" required>
                            <label for="register-email">Email</label>

                        </div>
                        <div class="form-floating  mb-3">
                            <input type="text" class="form-control" name="tel" id="tel" maxlength="10" required>
                            <label for="register-tel">Telephone</label>

                        </div>
                        <div class="text-center">
                            <button type="submit" class="w-100 btn btn-lg btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../controller/login.js"></script>
</body>

</html>