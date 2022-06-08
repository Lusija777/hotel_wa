<?php
session_start();
include('database.php');
include('funkcie_vseobecne.php');
include('funkcie.php');

$title = 'Rezervácia';
 
$form_submit = false;
$hack = false;
$available_rooms = [];
if (isset($_SESSION['mistake'])){
	$mistake = $_SESSION['mistake'];
	unset($_SESSION['mistake']);
}
else{
	$mistake = [];
}


if (isset($_GET['number_of_people'], $_GET['daterange'])) {
	$form_submit = true;
	$number_of_people = load_from_get('number_of_people');
	
	$daterange = load_from_get('daterange');
	if ($number_of_people == ''){$mistake["number_of_people"] = 1;}
	if ($daterange == ''){$mistake["daterange"] = 1;}
	$daterange = explode(" do ", $daterange);
	if (1 === count($daterange)) {
		$daterange[] = date('Y-m-d', strtotime('+1 day', strtotime($daterange[0])));
	}
	foreach ($daterange as $date) {
		if (DateTime::createFromFormat('Y-m-d', $date) === false) {
			// it's not a date
			if (!isset($mistake['daterange'])){
				$hack = true;
			}
			break;
		}
		if (DateTime::createFromFormat('Y-m-d', $date) < new DateTime()) {
			if (!isset($mistake['daterange'])){
				$hack = true;
			}
			break;
		}
	}
	$number_of_people = (int)$number_of_people;
	if (0 === $number_of_people || $number_of_people != load_from_get('number_of_people')) {
		if (!isset($mistake['number_of_people'])){
				$hack = true;
			}
	}
	if (isset($_GET['number_of_people'], $_GET['daterange']) && !isset($_SESSION['user'])){
		$_SESSION['targetPath'] = sprintf('rezervacia.php?daterange=%s+do+%s&number_of_people=%d',$daterange[0],$daterange[1], $number_of_people);
		$_SESSION['mistake'] = $mistake;
		redirect('login.php');
	}
	if (false === $hack) {
		$available_rooms = find_available_rooms($mysqli, $daterange, $number_of_people);
	}
}
include('hlavicka.php');
include('nav.php');
?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<section>
		<?php
		if (isset($_GET['message'])){
			?>
			<div class="alert alert-warning">
				<?php
				if ($_GET['message'] == 'occupied'){
					echo "Izba je v tomto termíme už obsadená.";
				}
				else {
					echo "Neznáma správa.";
				}
			?>
			</div>
		<?php } ?>
		<form method="get">		
			<div class="mb-3">
				<label for="daterange">Termín</label>
				<input id="daterange" name="daterange" class="js-flatpickr form-control <?php if(isset($mistake['daterange'])){echo " is-invalid";} ?>" type="text" data-today="<?= date('Y-m-d'); ?>" value="<?php if (isset($_GET['daterange']) && !isset($mistake['daterange'])) echo $_GET['daterange']; ?>">
				<div class="invalid-feedback">Prosím vyplňte tento údaj.</div>
			</div>
			<div class="mb-3">
				<label for="number_of_people" class="form-label">Počet osôb</label> 
				<input id="number_of_people" min="1" name="number_of_people" class="form-control <?php if(isset($mistake['number_of_people'])){echo " is-invalid";} ?>" type="number" value="<?php if (isset($_GET['number_of_people']) && !isset($mistake['number_of_people'])) echo $_GET['number_of_people']; ?>">
				<div class="invalid-feedback">Prosím vyplňte tento údaj.</div>
			</div>	
			<button type="submit" class="btn btn-primary mb-1">Ukáž dostupnosť izieb</button>
		</form>
	</section>
	<?php
	if (true === $hack) {
		hack_attempt();
	}
	else if (empty($mistake)) {
		if (true === $form_submit) {
			if ([] === $available_rooms) {
				?>
				<div class="alert alert-warning">V tomto termíne a pre tento pocet osob nie je dostupna izba</div>
				<?php
			}
			else {
				?>
					<div>V termíne od <?= date('j.n.Y',  strtotime($daterange[0])); ?> do <?= date('j.n.Y', strtotime($daterange[1])); ?> pre <?= $number_of_people; ?> <?= (1 === $number_of_people) ? "osobu" : (5 <= $number_of_people ? "osôb" : "osoby"); ?> sú voľné tieto apartmány:</div>
				<?php
				print_rooms($available_rooms, true, true, $daterange, $number_of_people);
			}
		}
	}
	?>
</div>
<?php include('pata.php'); ?>
