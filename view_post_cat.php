<?php
include_once 'database.php';
include_once 'session.php';

//thiscode will be executed when the delete button is clickes and this will delete the post and the categories with the post_id thay is passed in th form 
if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];

    $delete_categories_query = "DELETE FROM post_categories WHERE post_id = $post_id";
    if (mysqli_query($conn, $delete_categories_query)) {

        $delete_post_query = "DELETE FROM posts WHERE id = $post_id";
        if (mysqli_query($conn, $delete_post_query)) {
            echo "Post  deleted successfully";
        } else {
            echo "Error deleting post: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting  categories: " . mysqli_error($conn);
    }
}


//this query will select all the posts and the categories that are associated with the post and it will display the post and the categories in the table 
$sql = " SELECT posts.id, posts.title, posts.content, GROUP_CONCAT(categoriies.device SEPARATOR ', ') AS combined_categories
FROM posts
JOIN post_categories ON posts.id = post_categories.post_id
JOIN categoriies ON post_categories.cat_id = categoriies.id
GROUP BY 
    posts.id, 
    posts.title, 
    posts.content
ORDER BY 
    posts.id ASC ";

$query = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post and Categories Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<?php include_once 'navbar.php'; ?>

    <div class="container">
        <h1 style="text-align: center;">Posts</h1>
        <h2>Posts:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Categories</th>
                    <th scope="col">Actions Button</th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($query)) {

                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['content'] . "</td>";
                    echo "<td>" . $row['combined_categories'] . "</td>";
                    echo "<td>";

                    //this is the form that will be submitted when the update button is clicked  

                    echo "<form method='post' action='update_post.php?id=" . $row['id'] . "'>";

                    echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' class='btn btn-success'>Update</button>";
                    echo "</form>";

                    //this is the form that will be submitted when the delete button is clicked  

                    echo "<form method='post' onsubmit='return confirmDelete()'>";
                    echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete_post' class='btn btn-danger'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this post?");
        }
    </script>


</body>

</html>