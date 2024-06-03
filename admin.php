<?php
include_once('database.php');
include_once 'session.php';

$name = $email = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Profile Picture Upload
    $fileName = $_FILES["profile_picture"]["name"];
    $tmpName = $_FILES["profile_picture"]["tmp_name"];
    $folder = 'image/' . $fileName;

    if (move_uploaded_file($tmpName, $folder)) {
        $sql_upload_img = "INSERT INTO uploads (image) VALUES ('$fileName')";
        $query_upload_img = mysqli_query($conn, $sql_upload_img);

        if ($query_upload_img) {
            echo "<h2>Profile picture uploaded successfully</h2>";
            
            $sql_update_profile_picture = "UPDATE employess SET profile_picture = '$fileName' WHERE email = '$email'";
            $query_update_profile_picture = mysqli_query($conn, $sql_update_profile_picture);
            if (!$query_update_profile_picture) {
                echo "<h2>Failed to update profile picture</h2>";
            }
        } else {
            echo "<h2>Failed to upload profile picture</h2>";
        }
    } else {
        echo "<h2>Error uploading profile picture</h2>";
    }





    // Inserting User Data in registration 
    $sql = "INSERT INTO employess (name, email, password,profile_picture) VALUES ('$name', '$email', '$password' , '$profile_picture')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Admin Page</title>
    <style>
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container .content {
            text-align: center;
        }

        .content h2 {
            font-size: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
    
        <h2>User Registration</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

    </div>
</div>

</body>
</html>
