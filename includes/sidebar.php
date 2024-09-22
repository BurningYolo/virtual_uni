<div class="d-flex">

        <!-- Toggler for Mobile -->
      

        <!-- Sidebar -->
        <div class="bg-dark text-white p-3 sidebar" id="sidebar">
            <a href="" class="d-flex align-items-center mb-3 mb-md-0 text-white text-decoration-none">
                <span class="fs-4">Virtual_Uni</span>
            </a>
            <hr>
            <ul class="nav flex-column mb-auto">
                <li>
                    <a href="?page=dashboard" class="nav-link text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="?page=library" class="nav-link text-white">
                        Library
                    </a>
                </li>
                <li>
                    <a href="?page=events" class="nav-link text-white">
                      Events  
                    </a>
                </li>
                <li>
                    <a href="?page=discussion_boards" class="nav-link text-white">
                        Discussion Boards
                    </a>
                </li>
                <li>
                    <a href="?page=profile" class="nav-link text-white">
                        Profile
                    </a>
                </li>
                <li>
                    <a href="?page=feedback" class="nav-link text-white">
                        Feedback
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                  
                    <strong><?php echo $_SESSION['username'] ;  ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="?page=profile">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="handlers/logout_handler.php">Sign out</a></li>
                </ul>
                <br>
                <p><?php echo $_SESSION['role'] ;  ?></p>
            </div>
        </div>

        <!-- Main Content -->
 
    </div>
 