<?php
include_once 'database.php';
include_once 'session.php';

// Handle changing task status................................................................
if (isset($_POST['change_status'])) {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['new_status'];

    $sql_update_status = "UPDATE todos SET status='$new_status' WHERE id=$task_id";
    $query_update_status = mysqli_query($conn, $sql_update_status);

    if ($query_update_status) {
        echo "Status updated successfully";
    } else {
        echo "Failed to update status";
    }
}



// Handle adding new task.....................................................................
if (isset($_POST['add_task'])) {
    $task = $_POST['task'];
    $assigned_to = $_POST['assigned_to'];

    $sql_insert = "INSERT INTO todos (task, assigned_to, status) VALUES ('$task', '$assigned_to', 'pending')";
    $query_insert = mysqli_query($conn, $sql_insert);

    if ($query_insert) {
        echo "Task added successfully";
    } else {
        echo "Failed to add task";
    }
}




// Retrieve all tasks........................................................................
$sql_all_tasks = "SELECT id, task, assigned_to, status FROM todos";
$query_all_tasks = mysqli_query($conn, $sql_all_tasks);



// Retrieve list of employees.................................................................
$sql_query = "SELECT id, name FROM employess";
$user_query = mysqli_query($conn, $sql_query);
$employees = mysqli_fetch_all($user_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Admin To-Do List</title>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;">Admin To-Do List</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-3">
                <label for="task">Task:</label>
                <input type="text" name="task" id="task" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="assigned_to">Assign To:</label>
                <select name="assigned_to" id="assigned_to" class="form-control" required>
                    <option value="">Select User</option>
                    <?php foreach ($employees as $employee) : ?>
                        <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- this button for add task  -->
            <input type="submit" value="Add Task" name="add_task" class="form-control btn btn-primary">
        </form>

        <!-- task table show to admin  -->
        <h2>Tasks:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Task Description</th>
                    <th scope="col">Assigned To</th>
                    <th scope="col">Status</th>
                    <th scope="col">Change Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Display tasks based on status pending, In progress, completed -->
                <?php while ($row = mysqli_fetch_assoc($query_all_tasks)) : ?>
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
                        <td><?php echo $row['status']; ?></td>

                        <!-- this is for status update by admin using select option  -->
                        <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="status-form">
                                <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                <select name="new_status" class="form-control status-select" required>
                                    <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="inprogress" <?php if ($row['status'] == 'inprogress') echo 'selected'; ?>>In Progress</option>
                                    <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                </select>
                                <input type="hidden" name="change_status" value="1"> 
                                <input type="submit" style="display: none;"> 
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.status-select').change(function() {
                $(this).closest('.status-form').submit();
            });
        });
    </script>
</body>

</html>
