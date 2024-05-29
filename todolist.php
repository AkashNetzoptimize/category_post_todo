<?php
include_once 'database.php';
include_once 'session.php';

// Retrieve the user's ID based on their email...............................................
$email = $_SESSION['email'];
$sql_user = "SELECT id FROM employess WHERE email = '$email'";
$query_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($query_user);
$user_id = $user['id'];


//  tasks assigned to the logged-in user......................................................
$sql_select = "SELECT * FROM todos WHERE assigned_to = $user_id";
$query_select = mysqli_query($conn, $sql_select);


// Retrieve list of employees.................................................................
$sql_query = "SELECT id, name FROM employess";
$user_query = mysqli_query($conn, $sql_query);
$employees = mysqli_fetch_all($user_query, MYSQLI_ASSOC);

// CHECK IF THE FORM IS SUBMITTED  ...........................................................
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['update_status'])) {
        if(isset($_POST['task_status'])) {
            $task_statuses = $_POST['task_status'];
            foreach($task_statuses as $task_id => $status) {
                $sql_update = "UPDATE todos SET status = '$status' WHERE id = $task_id";
                mysqli_query($conn, $sql_update);
            }
        }
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Admin To-Do List</title>
</head>

<body>
    <div class="container">
        <h2>Tasks:</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Task Description</th>
                        <th scope="col">Assigned To</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($query_select)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['task']; ?></td>
                            <td>
                                <?php
                                $assigned_user = "Not assigned to a user";
                                foreach ($employees as $employee) {
                                    if ($employee['id'] == $row['assigned_to']) {
                                        $assigned_user = $employee['name'];
                                        break;
                                    }
                                }
                                echo $assigned_user;
                                ?>
                            </td>
                            <td>
                                <select name="task_status[<?php echo $row['id']; ?>]">
                                    <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="inprogress" <?php if ($row['status'] == 'inprogress') echo 'selected'; ?>>In Progress</option>
                                    <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                </select>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
        </form>
    </div>
</body>

</html>
