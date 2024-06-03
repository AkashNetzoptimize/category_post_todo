<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="displayusers.php">Display Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category_page.php">Category Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="todos.php">Todos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="posts.php">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload.php">Upload Image</a>
                </li>
            </ul>
            <form class="d-flex" action="search.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
            
        
            <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
                <?php
               
                $sql_select_profile = "SELECT image FROM uploads WHERE id = (SELECT MAX(id) FROM uploads)";
                $query_select_profile = mysqli_query($conn, $sql_select_profile);
                $profile_picture = mysqli_fetch_assoc($query_select_profile)['image'];
                ?>
                <?php if($profile_picture): ?>
                    <img src="image/<?php echo $profile_picture; ?>" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px;">
                <?php endif; ?>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Register</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

