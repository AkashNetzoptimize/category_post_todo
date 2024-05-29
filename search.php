<?php
include_once 'database.php';


if (isset($_GET['search_query'])) {
    // Get the search query
    $searchQuery = $_GET['search_query'];

    // Perform SQL query to search posts
    $sql = "SELECT * FROM posts WHERE title LIKE '%$searchQuery%' ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Results</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        </style>
    </head>

    <body>
        <div class="container">
            <h1 class="mt-5 mb-4 text-center">Search Results</h1>
            <div class="posts">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='post card mb-3'>";
                        echo "<div class='card-body'>";
                        echo "<h3 class='card-title'><a href='single_post.php?post_id=" . $row['id'] . "'>" . $row['title'] . "</a></h3>";
                        echo "<p class='card-text'>" . $row['content'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No results found.</p>";
                }
                ?>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: posts.php");
    exit();
}
?>

