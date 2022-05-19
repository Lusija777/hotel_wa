<?php
session_start();
include('database.php');

$title = 'Objednávka';
include('funkcie_vseobecne.php');
include('funkcie.php');
$user = find_user_from_session($mysqli, '/projekt/rezervacia.php');

$hack = false;
$room_id = (int)load_from_get('room_id');
$daterange = load_from_get('daterange');
$number_of_people = (int)load_from_get('number_of_people');

$daterange = explode(" do ", $daterange);
if (1 === count($daterange)) {
	$daterange[] = date('Y-m-d', strtotime('+1 day', strtotime($daterange[0])));
}
foreach ($daterange as $date) {
	if (DateTime::createFromFormat('Y-m-d', $date) === false) {
		// it's not a date
		$hack = true;
		break;
	}
	if (DateTime::createFromFormat('Y-m-d', $date) < new DateTime()) {
		$hack = true;
		break;
	}
}
if (0 === $number_of_people || $number_of_people != load_from_get('number_of_people')) {
	$hack = true;
}
if (0 === $room_id || $room_id != load_from_get('room_id')) {
	$hack = true;
}
$room = find_room($mysqli, $room_id);
if (null === $room) {
	$hack = true;
}
include('hlavicka.php');
include('nav.php');
?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<?php
	if (isset($_POST['odosli'])){
		if (false == check_number_of_people($mysqli, $room_id, $number_of_people)) {
			hack_attempt();
		}
		else {
			if (true == check_if_order_exists($mysqli, $room_id, $daterange[0], $daterange[1])){
				redirect(sprintf('/projekt/rezervacia.php?message=occupied&daterange=%s+do+%s&number_of_people=%d',$daterange[0],$daterange[1], $number_of_people));
			}
			else {
				?>
				<div class="alert alert-success">Objednávka bola úspešne odoslaná.</div>
				<?php
				add_to_orders($mysqli, $user['id'], $room_id, $number_of_people, $daterange);
			}
		}
	}
	else{
		if(true === $hack){
			hack_attempt();
		}
		else{
			?>
			<div class="row">
				<div class="col-lg-6 mb-2 mb-lg-0">
					<section>
						<?php
						print_user($mysqli, $user['id']);
						?>
						<form method="post">
						<button type="submit" name="odosli" class="btn btn-primary">Odošli objednávku</button>
						</form>
					</section>
				</div>
				<div class="col-lg-6">
					<?php
					print_rooms([$room], false, false, $daterange, $number_of_people);
					?>
				</div>
			</div>
		<?php
		}	
	}
?>
</div>
<?php include('pata.php'); ?>
