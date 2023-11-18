<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="mt-5 sidebar-sticky">
        <ul class="nav flex-column">

          <?php 


            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);

          ?>


          <li class="nav-item">
            <a class="nav-link" href="Index.php">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
            <li class="nav-item">
                <a class="nav-link" href="theaters.php">
                    <span data-feather="video"></span>
                    Theaters
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="screens.php">
                    <span data-feather="monitor"></span>
                    Screens
                </a>
            </li>
         <li class="nav-item">
            <a class="nav-link" href="movies.php">
              <span data-feather="film"></span>
              Movies
            </a>
          </li>
         <li class="nav-item">
            <a class="nav-link" href="showtimes.php">
              <span data-feather="aperture"></span>
              Showtimes
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="bookings.php">
              <span data-feather="credit-card"></span>
              Bookings
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="feedback.php">
              <span data-feather="rss"></span>
              Feedback
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="users.php">
              <span data-feather="users"></span>
              Users
            </a>
          </li>
           
        </ul>


       
      </div>
    </nav>


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="mt-5 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hello <?php echo $_SESSION["admin"]; ?></h1>
        
      </div>