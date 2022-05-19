<?php
session_start();
include('funkcie_vseobecne.php');
include('funkcie.php');
include('database.php');
if(!isset($_SESSION['user'])) {
	$user = null;
}
else {
	$user = find_user($mysqli, $_SESSION['user']);
}
if ($user != null) {
	if (isset($_SESSION['targetPath'])){
		redirect($_SESSION['targetPath']);
	}
	if($user['role'] == 'admin'){
		redirect('/projekt/admin/admin.php');
	}
	else if ($user['role'] == 'user'){
		redirect('/projekt/user/user.php');
	}
}
else {

$title = 'Prihlásenie';
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
	if (isset($_POST["prihlas"])) {
		
		$password = load_from_post('password');
		$email = load_from_post('email');

		$user = login($mysqli, $password, $email);
		if (null == $user){
			?>
			<div class="alert alert-warning">Nepodarilo sa prihlásiť.</div>
			<?php
		}
		else if ($user['role'] === 'admin'){
			$_SESSION['user'] = $user['id'];
			redirect($_SESSION['targetPath'] ?? '/projekt/admin/admin.php');
		}
		else if ($user['role'] === 'user'){
			$_SESSION['user'] = $user['id'];
			redirect($_SESSION['targetPath'] ?? '/projekt/user/user.php');
			
		}
	}
	?>
	<form method="post">
		 <div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input name="email" type="text" class="form-control" id="email" aria-describedby="mailHelp"  value="<?php if (isset($email)) echo $email; ?>">
					<div id="mailHelp" class="form-text">Napríklad: lila@lila.sk.</div>
		 </div>
		 <div class="mb-3">
			<label for="password" class="form-label">Heslo</label>
			<input name="password" type="password" class="form-control" id="password">
		 </div>
		<button type="submit" name="prihlas" class="btn btn-primary">Prihlás sa</button>
	</form>
	<hr>
	<a href="/projekt/registracia.php">Zaregistuj sa</a>
	</section>
</div>
<?php include('pata.php'); }?>