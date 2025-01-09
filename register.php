<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $dob = $_POST['dob'];
    $profile_picture = $_FILES['profile_picture'];

    // Handle the profile picture upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_picture["name"]);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    if (getimagesize($profile_picture["tmp_name"]) === false) {
        $upload_ok = 0;
        $error_message = "File is not an image.";
    }

    // Check file size (limit to 5MB)
    if ($profile_picture["size"] > 5000000) {
        $upload_ok = 0;
        $error_message = "File is too large.";
    }

    // Allow certain file formats
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        $upload_ok = 0;
        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    if ($upload_ok === 0) {
        // Error occurred during upload
        $error_message = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
            // Insert user data into the database
            $sql = "INSERT INTO users (username, email, password, name, phone, address, pincode, dob, profile_picture) 
                    VALUES ('$username', '$email', '$password', '$name', '$phone', '$address', '$pincode', '$dob', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                $success_message = "Registration successful!";
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
        }
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5em;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="register-container">
    <span class="close-btn" onclick="window.location.href='login.php'">&times;</span>
    <h2 class="text-center mb-4">User Registration</h2>

    <!-- Display success or error messages -->
    <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
    <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>

    <form method="POST" action="register.php" id="registerForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone number" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" placeholder="Enter address" required>
        </div>

        <div class="mb-3">
            <label for="pincode" class="form-label">Pincode</label>
            <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter pincode" required>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" id="dob" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">REGISTER</button>
    </form>

    <br>
    <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
</div>

<script>
    // JavaScript validation for registration form
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirm_password = document.getElementById('confirm_password').value;

        if (password !== confirm_password) {
            event.preventDefault();  // Prevent form submission
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Passwords do not match!',
                confirmButtonText: 'Try Again'
            });
        }
    });
</script>

</body>
</html>
