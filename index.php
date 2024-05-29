<?php

include_once 'database.php';

include_once 'session.php';
//inserting value in table 

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $phone  = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userSelect = $_POST['userSelect'];

    //this is use to run sql query.

    $sql = "INSERT INTO employess(name,phone,email,password,userSelect) VALUES('$name','$phone','$email','$password', '$userSelect')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo "data inserted ";
    } else {
        echo "data not inserted";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Registration form</title>
</head>

<body>

    <div class="container">

        <h1 style="text-align: center;">Registration Form</h1>

        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="name">Name:</label class="form-label">
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone">Phone:</label class="form-label">
                <input type="tel" name="phone" id="phone" class="form-control">
            </div>
            <div class="mb-3">
                <label for="email">Email:</label class="form-label">
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password">Password:</label class="form-label">
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <select class="form-select" aria-label="Default select example" required name="userSelect">
                    <option value="">Select user or admin </option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <input type="submit" value="Register" name="submit" class="form-control btn btn-primary ">

            <p>already have account? <a href="login.php">login now</a></p>
        </form>
    </div>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>