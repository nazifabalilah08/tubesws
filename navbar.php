<!DOCTYPE HTML>
<html lang="en">

<style>

.btn {
  padding: .45rem 1.5rem .35rem;
}

.gradient-custom {
  /* fallback for old browsers */
  background: #c471f5;

  /* Chrome 10-25, Safari 5.1-6 */
  background: -webkit-linear-gradient(to right, rgba(196, 113, 245, 1), rgba(250, 113, 205, 1));

  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to right, rgba(196, 113, 245, 1), rgba(250, 113, 205, 1));
}


</style>

  <body>

    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark gradient-custom">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Navbar brand -->
    <a class="navbar-brand" href="index.php" >
                    <img src="icon/logox.png" class="logo img-fluid" >
                    <span>
                        The Wibzz
                        
                    </span>
                </a>
    

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="Toggle navigation">
      <i class="fas fa-bars text-light"></i>
    </button>

      <!-- Right links -->
      <div class="collapse navbar-collapse justify-content-end" id="navbar">

        <ul class="navbar-nav">
        <li class="nav-item">
        <a href="dashboard.php" class="nav-link navbar-link-2 waves-effect">
        Dashboard
        </a>
        </li>
        <li class="nav-item">
        <a href="index.php" class="nav-link navbar-link-2 waves-effect">
        Home
        </a>
        </li>
    
        <li class="nav-item">
        <a class="nav-link navbar-link-2 waves-effect" href="#!" data-toggle="modal" data-target="#myModal">Search</a>
        </li>
        </ul>
        </div>
        
     <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
          <!-- konten modal-->
          <div class="modal-content modal-xl">
            <!-- heading modal -->
            <div class="modal-header modal-xl">
              <form action="search.php" method="get" class="form-inline form-xl">
                <input name="keyword" class="form-control" type="text" style="width: 376px;" placeholder="Search" aria-label="Search">
                <button class="btn btn-dark" type="submit"><img src="icon/search.png" height="30"></button>
              </form>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
          </div>
        </div>
      </div>
    
      <!-- Right links -->

      
    </div>
    <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->
  </body>
</html>
