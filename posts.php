<?php
//this include the database 
include_once 'database.php';
include_once 'session.php';

// after clicking on the add_post button
if (isset($_POST['add_post'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];

    if (isset($_POST['categories'])) {
        $selected_categories = $_POST['categories'];
        $categories_post = implode(',', $_POST['categories']);
    } else {
        $categories_post = '';
    }

    $sql = "INSERT INTO posts (title, content, categories_post) VALUES ('$title', '$content', '$categories_post')";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $post_id = mysqli_insert_id($conn);
        foreach ($selected_categories as $category) {
            $sql = "INSERT INTO post_categories (cat_id,post_id) VALUES ('$category','$post_id')";
            $query = mysqli_query($conn, $sql);
        }
        echo "Post added successfully";
    } else {
        echo "Failed to add post: " . mysqli_error($conn);
    }

    echo $category;
}


$sql_categ = "SELECT * FROM categoriies ";
$query_categ = mysqli_query($conn, $sql_categ);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once 'navbar.php'; ?>

    <div class="container">
       

        <h1 style="text-align: center;">Posts</h1>

        <form action="posts.php" method="POST">
            <div class="mb-3">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="content">Content:</label>
                <textarea name="content" id="content" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="categories">Categories:</label><br>
                <?php
                while ($row = mysqli_fetch_assoc($query_categ)) {
                    echo '<input type="checkbox" name="categories[]" value="' . $row['id'] . '"> ' . $row['device'] . '<br>';
                }
                ?>
            </div>
            <input type="submit" value="Add Post" name="add_post" class="form-control btn btn-primary">

        </form>
        <br>
        <button class=" btn btn-danger"><a style="color: #fff; text-decoration: none;" href="view_post_cat.php">View Post</a></button>
    </div>

</body>

</html>