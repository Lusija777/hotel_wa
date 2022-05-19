<?php
session_start();
include('database.php');

$title = 'Objednávka';
include('funkcie_vseobecne.php');
include('funkcie.php');
include('hlavicka.php');
include('nav.php');

$user = find_user_from_session($mysqli, null);
	
$order_id = (int)load_from_get('id');
?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<?php 
	if (0 === $order_id || $order_id != load_from_get('id')){
		hack_attempt();
	}
	else {
		if ($user['role'] == 'user'){
			?>
				<div class="alert alert-warning">K tejto objednávke nemáte prístup.</div>
			<?php
		}
		else if($user['role'] == 'admin'){
			if(false == remove_order($mysqli, $order_id)){
				?>
					<div class="alert alert-warning">Objednávka neexistuje.</div>
				<?php
			}
			else {
				?>
					<div class="alert alert-success">Objednávka bola úspešne vymazaná.</div>
				<?php
			}
		}
	}
	?>
	
</div>
<?php include('pata.php');?>