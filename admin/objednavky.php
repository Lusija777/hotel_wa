<?php
session_start();
include('../funkcie_vseobecne.php');
include('../funkcie.php');
include('../database.php');

$user = find_user_from_session($mysqli, null, 'admin');
$title = 'Objednávky - admin';
include('../hlavicka.php');
include('../nav.php');
$page = (int)load_from_get('page');
?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<div class="row">
		<div class="col-2">
			<nav class="nav flex-column">
			  <a href="/projekt/admin/objednavky.php?page=1" class="nav-link">Objednávky</a>
			  <a href="/projekt/admin/klienti.php?page=1" class="nav-link">Klienti</a>
			  <a href="/projekt/odhlasit.php" class="nav-link">Odhlás</a>
			</nav>
		</div>
		<div class="col-10">
			<?php
			if ($page > 0) {
				?>
				<div>Všetky objednávky:</div>
				<?php
				all_orders($mysqli, $page, 5, 1);
				paginate($page);
			}
			else {
				hack_attempt();
			}?>
		</div>
	</div>
	
</div>
<?php include('../pata.php'); ?>