<?php
include_once 'database.php';
include_once 'session.php';

if (isset($_POST['add_categories'])) {

    $parent_id = $_POST['parent_id'];
    $device = $_POST['device'];

    if (empty($parent_id)) {
        $parent_id = "NULL";
    } else {
        $parent_id;
    }

    $sql = "INSERT INTO categoriies (parent_id, device) VALUES ('$parent_id', '$device')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo "Category added successfully";
    } else {
        echo "Failed to add category";
    }
}

$sql = "SELECT * FROM categoriies";
$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<style>
    .container {
        width: 100%;
        min-height: 100vh; 
    }
</style>

<body>
<?php include_once 'navbar.php'; ?>

    <div class="container">

        <h1 style="text-align: center;">Categories</h1>

        <form action="categories.php" method="POST">
            <div class="mb-3">
                <select class="form-select" name="parent_id">
                    <option value="">Select category</option>
                    <option value="0">None</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo '<option value="' . $row['id'] . '"=>' . $row['device'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="device">Category Name:</label>
                <input type="text" name="device" id="device" class="form-control" required>
            </div>
            <input type="submit" value="Add Category" name="add_categories" class="form-control btn btn-primary" required>
        </form>

        <h2>Categories:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Parent ID</th>
                    <th scope="col">Device</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($query, 0);
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . " </td>";
                    echo "<td>" . $row['parent_id'] . " </td>";
                    echo "<td>" . $row['device'] . " </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>

