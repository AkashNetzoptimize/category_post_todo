<?php
include_once('database.php');
include_once 'session.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    // Check if the user has uploaded a profile picture
    $email = $_SESSION['email'];
    $sql_select_profile = "SELECT profile_picture FROM employess WHERE email = '$email'";
    $query_select_profile = mysqli_query($conn, $sql_select_profile);

    if($query_select_profile && mysqli_num_rows($query_select_profile) > 0) {
        $profile_picture = mysqli_fetch_assoc($query_select_profile)['profile_picture'];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="user.php">User Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="category_page.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="todolist.php">Todo</a>
                </li>
            </ul>
            <form class="d-flex" action="search.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
            <!-- Display profile picture -->
            <img src="image/<?php echo $profile_picture; ?>" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px;">
            <?php
                echo '<ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                      </ul>';
            ?>
        </div>
    </div>
</nav>

<?php
    } else {
        echo "Error: Profile picture not found.";
    }
}
?>
