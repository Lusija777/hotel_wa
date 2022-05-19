<?php
session_start();
include('../funkcie_vseobecne.php');
include('../funkcie.php'); 
include('../database.php');
$user = find_user_from_session($mysqli, null, 'user');

$title = 'Používateľ - '.$user['name'].' '.$user['last_name'];
include('../hlavicka.php');
include('../nav.php');

?>

<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	
	<div class="row">
		<div class="col-2">
			<nav class="nav flex-column">
			  <a href="/projekt/user/user_objednavky.php?page=1" class="nav-link">Objednávky</a>
			  <a href="/projekt/user/zmena_udajov.php" class="nav-link">Zmena údajov</a>
			  <a href="/projekt/odhlasit.php" class="nav-link">Odhlás</a>
			</nav>
		</div>
		<div class="col-10">
		</div>
	</div>
</div>
<?php include('../pata.php'); ?>