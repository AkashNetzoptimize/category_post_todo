<?php  
include_once('database.php'); 
include_once 'session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    $fileName = $_FILES["profile_picture"]["name"];
    $tmpName = $_FILES["profile_picture"]["tmp_name"];
    $folder = 'image/' . $fileName;

    if (move_uploaded_file($tmpName, $folder)) {
        $email = $_SESSION['email'];
        $sql_update_profile_picture = "UPDATE employess SET profile_picture = '$fileName' WHERE email = '$email'";

        if (mysqli_query($conn, $sql_update_profile_picture)) {
            echo "<h2>Profile picture uploaded successfully</h2>";
        } else {
            echo "<h2>Failed to update profile picture</h2>";
        }
    } else {
        echo "<h2>Error uploading profile picture</h2>";
    }
}

// Continue with the rest of your code
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

        .content h3 {
            font-size: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
        
        <!-- Image Upload Form -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Profile Picture</button>
        </form>
    </div>
</div>

</body>
</html>
