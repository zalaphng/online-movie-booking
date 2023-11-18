 <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#" style="background-color: rgba(255,255,255,0.92);">
      <img src="../assets/images/logo.png" alt="" style="width: 150px;">
  </a>

  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
    	<?php
    		if (isset($_SESSION['admin'])) {
    			?>
    				<a class="btn btn-primary text-white mr-4" href="../admin/logout.php"><i class="fa fa-sign-out"></i> Sign out</a>
    			<?php
    		}
    	?>
    </li>
  </ul>
</nav>