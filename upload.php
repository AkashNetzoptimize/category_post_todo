<?php
include('database.php');

if (isset($_POST["submit"])) {
    $fileName = $_FILES["image"]["name"];
    $tmpName = $_FILES["image"]["tmp_name"];
    $folder = 'image/' . $fileName;

    if (move_uploaded_file($tmpName, $folder)) {
        $sql_upload_img = "INSERT INTO uploads(image) VALUES('$fileName')";
        $query_upload_img = mysqli_query($conn, $sql_upload_img);

        if ($query_upload_img) {
            echo "<h2>File uploaded successfully</h2>";
        } else {
            echo "<h2>Failed to insert into database</h2>";
        }
    } else {
        echo "<h2>File not uploaded </h2>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once 'navbar.php'; ?>

    <form method="POST" enctype="multipart/form-data">
        <!-- Add profile picture input -->
        <div class="mb-3">
            <label for="image" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Upload</button>
    </form>

    <div class="img_container">
        <?php
        $sql_select_img = "SELECT * FROM uploads ORDER BY id DESC LIMIT 1"; 
        $query_select_img = mysqli_query($conn, $sql_select_img);

        if ($row = mysqli_fetch_assoc($query_select_img)) {
        ?>
            <img width="50%" src="image/<?php echo $row['image']?>" />
        <?php } ?>
    </div>
</body>

</html>
