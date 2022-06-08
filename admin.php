<?php
session_start();
include('funkcie_vseobecne.php');
include('funkcie.php'); 
include('database.php');

$user = find_user_from_session($mysqli, null, 'admin');
$title = 'Admin';
include('hlavicka.php');
include('nav.php');

?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<div class="row">
		<div class="col-2">
			<nav class="nav flex-column">
			  <a href="objednavky.php?page=1" class="nav-link">Objednávky</a>
			  <a href="klienti.php?page=1" class="nav-link">Klienti</a>
			  <a href="odhlasit.php" class="nav-link">Odhlás</a>
			</nav>
		</div>
		<div class="col-10">
		</div>
	</div>
</div>
<?php include('pata.php'); ?>