<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="/projekt/index.php">
		<img src="/projekt/obrazky/house-chimney-solid.svg" alt="" width="40" height="24">
	</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		<li class="nav-item fw-bold"> <a href="/projekt/rezervacia.php" class="nav-link">Rezervácia</a></li>
		<li class="nav-item"> <a href="/projekt/ponuka.php" class="nav-link">Ponuka</a></li>
		<li class="nav-item"> <a href="/projekt/kontakt.php" class="nav-link">Kontakt</a></li>

      </ul>
	  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
		<?php
		if(!isset($_SESSION['user'])) {
			$user = null;
		}
		else {
			$user = find_user($mysqli, $_SESSION['user']);
		}
		if ($user == null) {
			echo '<li class="nav-item"> <a href="/projekt/login.php" class="nav-link">Prihlásenie</a></li>';
		}//border-bottom border-secondary border-width-5
		else {
			if ($user['role'] == 'admin') {
				echo '<li class="nav-item"> <a href="/projekt/admin/admin.php" class="nav-link">Admin</a></li>';
			}
			else {
				echo '<li class="nav-item"> <a href="/projekt/user/user.php" class="nav-link">Používateľ</a></li>';
			}
		}?> 
      </ul>
    </div>
  </div>
</nav>

