<?php
include_once 'database.php';


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM employess WHERE email ='$email' && password = '$password'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);
  
    if ($result) {
        $_SESSION['email'] = $email;
        $_SESSION['userSelect'] = $result['userSelect'];  
        $_SESSION['logged_in'] = true;

        if ($_SESSION['userSelect'] == 'admin') {
            header("Location: admin.php"); 
            exit();
        } else {
            header("Location: user.php");
            exit();
        }
    } else {
        echo "Login not successful";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <title>Login</title>
</head>

<body>
  <div class="container">

    <h1 style="text-align: center;">Login Form</h1>

    <form action="#" method="POST">
      <div class="mb-3">
        <label for="email">Email:</label class="form-label">
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password">Password:</label class="form-label">
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <input type="submit" value="login" name="login" class="form-control btn btn-primary">
      <p>already have account? <a href="index.php">Register now</a></p>
    </form>
  </div>
</body>

</html>


