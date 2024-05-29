<?php
// Include the database connection
include_once 'database.php';
include_once 'session.php';

// Check if ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Error: ID parameter is missing in the URL.";
    exit;
}

// Retrieve the post ID from the URL
$post_id = $_GET['id'];

// Check if the update_post form is submitted
if (isset($_POST['update_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the post details
    $update_post_query = "UPDATE posts SET title = '$title', content = '$content' WHERE id = $post_id";
    if (mysqli_query($conn, $update_post_query)) {
        echo "Post updated successfully";
    } else {
        echo "Error updating post: " . mysqli_error($conn);
    }

    // Update post categories
    $selected_categories = $_POST['categories']; // Get selected categories from the form
    $delete_old_categories_query = "DELETE FROM post_categories WHERE post_id = $post_id";
    mysqli_query($conn, $delete_old_categories_query); // Delete old categories associated with the post

    // Insert selected categories
    foreach ($selected_categories as $category_id) {
        $insert_category_query = "INSERT INTO post_categories (post_id, cat_id) VALUES ($post_id, $category_id)";
        mysqli_query($conn, $insert_category_query);
    }
}

// Fetch the post details based on the provided ID
$post_sql = "SELECT * FROM posts WHERE id = $post_id";
$post_query = mysqli_query($conn, $post_sql);
$post = mysqli_fetch_assoc($post_query);

// Fetch all categories from the categories table
$sql_categories = "SELECT * FROM categoriies";
$query_categories = mysqli_query($conn, $sql_categories);

// Fetch categories associated with the current post from the post_categories table
$post_categories = [];
$sql_post_categories = "SELECT cat_id FROM post_categories WHERE post_id = $post_id";
$query_post_categories = mysqli_query($conn, $sql_post_categories);
while ($row = mysqli_fetch_assoc($query_post_categories)) {
    $post_categories[] = $row['cat_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once 'navbar.php'; ?>

    <div class="container">
        <h1 style="text-align: center;">Update Post</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $post['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="content">Content:</label>
                <textarea name="content" id="content" class="form-control" required><?php echo $post['content']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="categories">Categories:</label><br>
                <?php
                // Loop through categories to display checkboxes
                while ($category = mysqli_fetch_assoc($query_categories)) {
                    $checked = in_array($category['id'], $post_categories) ? 'checked' : '';
                    echo '<input type="checkbox" name="categories[]" value="' . $category['id'] . '" ' . $checked . '> ' . $category['device'] . '<br>';
                }
                ?>
            </div>
            <input type="submit" value="Update Post" name="update_post" class="form-control btn btn-primary">
        </form>
        <br>
        <button class="btn btn-danger"><a style="color: #fff; text-decoration: none;" href="view_post_cat.php">View Post</a></button>
    </div>
</body>
</html>
