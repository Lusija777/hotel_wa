<?php
session_start();
include('database.php');

$title = 'Ponuka';
include('funkcie_vseobecne.php');
include('funkcie.php');
include('hlavicka.php');
include('nav.php');
?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<section>
		<form method="post">
			<label>Zoradiť izby podľa</label>
			<div class="mb-3">
				<button type="submit" name="nazov1" class="btn btn-sm btn-secondary">názvu (A-Z)</button>
				<button type="submit" name="nazov2" class="btn btn-sm btn-secondary">názvu (Z-A)</button>
				<button type="submit" name="cena1" class="btn btn-sm btn-secondary">ceny (od najnižšej)</button>
				<button type="submit" name="cena2" class="btn btn-sm btn-secondary">ceny (od najvyššej)</button>
			</div>
		</form>
	</section>
	<?php 
	$rooms = find_rooms($mysqli);
	print_rooms($rooms, true, false, []);
	?>
</div>
<?php include('pata.php'); ?>