<?php
include_once 'database.php';
include_once 'session.php';


// Function to fetch and display categories recursively
function displayCategories($conn, $parentDevice, $indent = 0)
{
    // Fetch child categories
    $sql_child = "SELECT DISTINCT device FROM categoriies WHERE parent_id = (SELECT id FROM categoriies WHERE device = '$parentDevice')";
    $query_child = mysqli_query($conn, $sql_child);

    while ($sub_row = mysqli_fetch_assoc($query_child)) {
        $childDevice = $sub_row['device'];
        echo "<li><a href='post_page.php?device=$childDevice' style='color: green; margin-left:" . ($indent * 30) . "px;'> →$childDevice</a></li>";

        // Recursively display children of child categories
        displayCategories($conn, $childDevice, $indent + 1);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #007bff;
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


        <h1>Categories</h1>
        <h2>Devices:</h2>
        <ul>
            <?php
            // Fetch all parent categories
            $sql = "SELECT DISTINCT device FROM categoriies WHERE parent_id = 0";
            $query = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($query)) {
                $parentDevice = $row['device'];
                echo "<li><a href='post_page.php?device=$parentDevice' style='color: red;'> 🌚$parentDevice</a>";

                // Call the recursive function to display child categories
                echo "<ul>";
                displayCategories($conn, $parentDevice, 1);
                echo "</ul>";

                echo "</li>";
            }
            ?>
        </ul>
    </div>

</body>

</html>