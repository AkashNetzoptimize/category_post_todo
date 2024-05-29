<?php

include_once 'database.php';
include_once 'session.php';


if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "SELECT title, content FROM posts WHERE id = $post_id";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
    $post_title = $row['title'];
    $post_content = $row['content'];

    // Fetch main comments
    $comments_sql = "SELECT * FROM comments WHERE post_id = $post_id AND parent_comment_id IS NULL";
    $comments_query = mysqli_query($conn, $comments_sql);
    $comments = mysqli_fetch_all($comments_query, MYSQLI_ASSOC);

    // Fetch replies
    $replies_sql = "SELECT * FROM comments WHERE post_id = $post_id AND parent_comment_id IS NOT NULL";
    $replies_query = mysqli_query($conn, $replies_sql);
    $replies = mysqli_fetch_all($replies_query, MYSQLI_ASSOC);
} else {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['comment'])) {
        // Add a main comment
        $comment = $_POST['comment'];
        $email = $_SESSION['email'];
        $get_user_name_sql = "SELECT name FROM employess WHERE email = '$email'";
        $get_user_name_query = mysqli_query($conn, $get_user_name_sql);
        $user_row = mysqli_fetch_assoc($get_user_name_query);
        $comment_username = $user_row['name'];

        $insert_comment_sql = "INSERT INTO comments (post_id, comment_username, comment) VALUES ($post_id, '$comment_username', '$comment')";
        $insert_comment_query = mysqli_query($conn, $insert_comment_sql);

        if (!$insert_comment_query) {
            die("Error in SQL query: " . mysqli_error($conn));
        }
    } elseif (isset($_POST['reply'])) {
        // Add a reply
        $reply = $_POST['reply'];
        $comment_id = $_POST['comment_id'];

        $email = $_SESSION['email'];
        $get_user_name_sql = "SELECT name FROM employess WHERE email = '$email'";
        $get_user_name_query = mysqli_query($conn, $get_user_name_sql);
        $user_row = mysqli_fetch_assoc($get_user_name_query);
        $reply_username = $user_row['name'];

        $insert_reply_sql = "INSERT INTO comments (post_id, parent_comment_id, comment_username, comment) VALUES ($post_id, $comment_id, '$reply_username', '$reply')";
        $insert_reply_query = mysqli_query($conn, $insert_reply_sql);

        if (!$insert_reply_query) {
            die("Error in SQL query: " . mysqli_error($conn));
        }
    }

    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
  

        <h1 class="mt-5 mb-4 text-center"><?php echo $post_title; ?></h1>
        <div class="post card mb-3">
            <div class="card-body">
                <p class="card-text"><?php echo $post_content; ?></p>
            </div>
        </div>


        <h2 class="mt-4">Comments</h2>
        <?php foreach ($comments as $comment) : ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $comment['comment_username']; ?></h5>
                    <p class="card-text"><?php echo $comment['comment']; ?></p>
                    <p class="card-text"><strong>Replies:</strong><br>
                        <?php
                        foreach ($replies as $reply) {
                            if ($reply['parent_comment_id'] == $comment['id']) {
                                echo $reply['comment_username'] . ": " . $reply['comment'] . "<br>";
                            }
                        }
                        ?>
                    </p>
                    <form method="post">
                        <div class="mb-3">
                            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                            <label for="reply" class="form-label">Reply</label>
                            <textarea class="form-control" id="reply" name="reply" rows="1" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Add a comment</h5>
                <form method="post">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <a href="category_page.php" class="btn btn-primary mt-4">Back to Posts</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB

</body>

</html>