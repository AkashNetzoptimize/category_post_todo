<?php

include_once 'database.php';
include_once 'session.php';

$task_id = $_GET['task_id'];

$sql_task = "SELECT * FROM todos WHERE id = $task_id";
$result_task = mysqli_query($conn, $sql_task);
if (!$result_task) {
    die("Error fetching task: " . mysqli_error($conn));
}
$task = mysqli_fetch_assoc($result_task);





$assigned_user_id = $task['assigned_to'];
$sql_assigned_user = "SELECT name, profile_picture FROM employess WHERE id = $assigned_user_id";
$result_assigned_user = mysqli_query($conn, $sql_assigned_user);
if (!$result_assigned_user) {
    die("Error fetching assigned user: " . mysqli_error($conn));
}
$assigned_user = mysqli_fetch_assoc($result_assigned_user);
$assigned_to_name = $assigned_user['name'];
$assigned_to_image = $assigned_user['profile_picture'];

$sql_comments = "SELECT c.*, e.profile_picture FROM todos_comments c
                 INNER JOIN employess e ON c.commenter_name = e.name
                 WHERE c.task_id = $task_id";
$result_comments = mysqli_query($conn, $sql_comments);
if (!$result_comments) {
    die("Error fetching comments: " . mysqli_error($conn));
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    $commenter_email = $_SESSION['email'];

    $sql_get_commenter_name = "SELECT name FROM employess WHERE email = '$commenter_email'";
    $result_get_commenter_name = mysqli_query($conn, $sql_get_commenter_name);
    if (!$result_get_commenter_name) {
        die("Error fetching commenter name: " . mysqli_error($conn));
    }
    $row_commenter_name = mysqli_fetch_assoc($result_get_commenter_name);
    $commenter_name = $row_commenter_name['name'];

    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);
    $sql_insert_comment = "INSERT INTO todos_comments (task_id, commenter_name, comment_text) VALUES ($task_id, '$commenter_name', '$comment_text')";
    if (!mysqli_query($conn, $sql_insert_comment)) {
        die("Error inserting comment: " . mysqli_error($conn));
    }

    header("Location: {$_SERVER['PHP_SELF']}?task_id=$task_id");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Discussion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #dc3545;
            font-size: 36px;
            margin-bottom: 20px;
            text-align: center;
        }

        .assigned-info {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .comment {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .comment p {
            margin: 0;
        }

        .comment img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            border: 1px solid black;
        }

        .commenter-name {
            font-size: 18px;
            font-weight: bold;
        }

        .add-comment-form {
            margin-top: 20px;
        }

        .submit-comment-btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Task: <?php echo htmlspecialchars($task['task']); ?></h2>
        <div class="assigned-info">
            <p><b>Assigned To:</b> <?php echo htmlspecialchars($assigned_to_name); ?></p>
            <?php if ($assigned_to_image) : ?>
                <img src="/image/<?php echo htmlspecialchars($assigned_to_image); ?>" alt="Assigned User Image">
            <?php endif; ?>
            <p><b>Status:</b> <?php echo htmlspecialchars($task['status']); ?></p>
        </div>

        <div class="discussions">
            <h3>Discussions:</h3>

            <?php while ($comment = mysqli_fetch_assoc($result_comments)) : ?>
                <div class="comment">
                    <?php if ($comment['profile_picture']) : ?>
                        <img src="/image/<?php echo htmlspecialchars($comment['profile_picture']); ?>" alt="Commenter image">
                    <?php endif; ?>
                    <p><span class="commenter-name"><?php echo htmlspecialchars($comment['commenter_name']); ?>:</span> <?php echo htmlspecialchars($comment['comment_text']); ?></p>
                </div>
                
            <?php endwhile; ?>
        </div>

        <!-- Add Comment Form -->
        <div class="add-comment-form">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?task_id=' . $task_id); ?>" method="POST">
                <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_id); ?>">
                <div class="mb-3">
                    <textarea class="form-control" id="comment_text" name="comment_text" rows="3" required></textarea>
                </div>
                <button type="submit" name="submit_comment" class="btn btn-primary submit-comment-btn">Submit Comment</button>
            </form>
        </div>
    </div>
</body>

</html>