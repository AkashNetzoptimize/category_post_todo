<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="user.php">User Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="category_page.php">categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="todolist.php">todo</a>
                    </li>
                  
                  
                </ul>
                <form class="d-flex" action="search.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
            <?php
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                echo '<ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                          </ul>';
            } else {
                echo '<ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Register</a>
                            </li>
                          </ul>';
            }
            ?>
            </div>
        </div>
    </nav>