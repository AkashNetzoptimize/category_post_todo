<?php
include_once 'database.php';
include_once 'session.php';

// Number of posts per page
$postsPerPage = 3;

if (isset($_GET['device'])) {
    $device = $_GET['device'];

    // Get page number
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $postsPerPage;

    // Fetch posts associated with the selected device
    $sql = "SELECT posts.id, posts.title, posts.content, GROUP_CONCAT(categoriies.device SEPARATOR ', ') AS combined_categories
            FROM posts
            JOIN post_categories ON posts.id = post_categories.post_id
            JOIN categoriies ON post_categories.cat_id = categoriies.id
            WHERE categoriies.device = '$device'
            GROUP BY posts.id, posts.title, posts.content
            ORDER BY posts.id ASC
            LIMIT $offset, $postsPerPage";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    // Get total number of posts
    $totalPostsSql = "SELECT COUNT(*) AS totalPosts
                      FROM posts
                      JOIN post_categories ON posts.id = post_categories.post_id
                      JOIN categoriies ON post_categories.cat_id = categoriies.id
                      WHERE categoriies.device = '$device'";
    $totalPostsResult = mysqli_query($conn, $totalPostsSql);
    $totalPostsRow = mysqli_fetch_assoc($totalPostsResult);
    $totalPosts = $totalPostsRow['totalPosts'];

    // Calculate total number of pages
    $totalPages = ceil($totalPosts / $postsPerPage);
} else {
    // Redirect if device is not provided
    header("Location: category_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        h1,
        h2 {
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        li a:hover {
            color: black !important;
        }

        .select_categories {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1 class="mt-5 mb-4 text-center">Posts Related to <?php echo $device; ?></h1>
        <div class="select_categories">
            <div class="dropdown">
                <h4>Select Categories</h4>
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown button
                </button>
                <ul class="dropdown-menu">
                    <?php

                    function displayCategories($conn, $parentDevice, $indent = 0)
                    {
                        $sql_child = "SELECT DISTINCT device FROM categoriies WHERE parent_id = (SELECT id FROM categoriies WHERE device = '$parentDevice')";
                        $query_child = mysqli_query($conn, $sql_child);

                        while ($sub_row = mysqli_fetch_assoc($query_child)) {
                            $childDevice = $sub_row['device'];
                            echo "<li><a class='dropdown-item' href='post_page.php?device=$childDevice' style='color: green; margin-left:" . ($indent * 20) . "px;'> →$childDevice</a></li>";
                            displayCategories($conn, $childDevice, $indent + 1);
                        }
                    }
                    displayCategories($conn, $device);
                    ?>
                </ul>
            </div>
            <div class="back-categories">
                <a href="category_page.php">Back to All Categories</a>
            </div>
        </div>

        <div class="posts">
            <?php
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<div class='post card mb-3'>";
                echo "<div class='card-body'>";
                echo "<h3 class='card-title'><a href='single_post.php?post_id=" . $row['id'] . "'>" . $row['title'] . "</a></h3>";
                echo "<p class='card-text'>" . $row['content'] . "</p>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='post_page.php?device=$device&page=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>