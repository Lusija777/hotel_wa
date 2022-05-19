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
	
$title = 'Registrácia';
include('hlavicka.php');
include('nav.php');
$mistake = [];
$hack = false;
$personal_info = true;
$email_in_database = false;
?>

<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<?php 
	if (isset($_POST['odosli'])) {
		$name = load_from_post('name');
		$password = load_from_post('password');
		$last_name = load_from_post('last_name');
		$street = load_from_post('street');
		$house_number = load_from_post('house_number');
		$city = load_from_post('city');
		$psc = load_from_post('psc');
		$email = load_from_post('email');
		$mobile = load_from_post('mobile');
		
		if ($name === null || $name == ''){$mistake["name"] = "nezadali ste meno";}
		if (strlen($name) >= 65){$mistake["name"] = "zlá dĺžka mena";}
		if (strlen($last_name) >= 65){$mistake["last_name"] = "zlá dĺžka priezviska";}
		if (strlen($street) >= 65){$mistake["street"] = "zlá dĺžka ulice";}
		if (strlen($city) >= 65){$mistake["city"] = "zlá dĺžka mesta";}
		
		if(strlen($password) < 5){$mistake["password"] = "heslo musí mať minimálne 5 znakov";}
		if ($password === null || $password == ''){$mistake["password"] = "nezadali ste heslo";}
		
		if ($last_name === null || $last_name == ''){$mistake["last_name"] = "nezadali ste priezvisko";}
		if(!is_numeric($house_number)){$mistake["house_number"] = "nezadali ste správny formát";}
		if ($house_number === null || $house_number == ''){$mistake["house_number"] = "nezadali ste číslo domu";}
		
		if ($street === null || $street == ''){$mistake["street"] = "nezadali ste ulicu";}
		if ($city === null || $city == ''){$mistake["city"] = "nezadali ste mesto";}
		
		if (!(preg_match('/^[0-9]{5}$/', $psc))) { $mistake["psc"] = "nezadali ste správny formát";}
		if ($psc === null || $psc == ''){$mistake["psc"] = "nezadali ste poštové smerovacie číslo";}
		
		if (!(preg_match('/^00421[0-9]{9}$/', $mobile))) { $mistake["mobile"] = "nezadali ste správny formát";}
		if ($mobile === null || $mobile == ''){$mistake["mobile"] = "nezadali ste telefón";}
		
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $mistake["email"] = "nezadali ste správny formát";}
		if ($email === null || $email == ''){$mistake["email"] = "nezadali ste email";}
		if( true == check_email_in_database($mysqli, $email)){
			$email_in_database = true;
			$mistake["email"] = "email už existuje";
		}

		if(!isset($_POST["check"])){
			$personal_info = false;
		}
	}
	if (isset($_POST['odosli']) && empty($mistake) && true == $personal_info && false == $email_in_database){
		// pridat do clientov a userov
		$user_id = add_to_users($mysqli, $name, $last_name, $street, $house_number, $city, $psc, $email, $mobile, $password);
		$_SESSION['user'] = $user_id;
		redirect($_SESSION['targetPath'] ?? '/projekt/user/user.php');
	}
	else{ // k method post <?php if(isset($_POST['odosli'])) {echo 'class="was-validated"';}?>
		<div class="row">
			<section>
				<form method="post">
					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="text" class="form-control<?php if(isset($mistake['email']) || true == $email_in_database){echo " is-invalid";} ?>" id="email" aria-describedby="mailHelp" name="email"  value="<?php if (isset($email)) echo $email; ?>">
						<div id="mailHelp" class="form-text">Napríklad: liliana@liliana.sk.</div>
						<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['email'])) ? " - ".$mistake['email'] : "";?>.</div>
					 </div>
					 <div class="mb-3">
						<label for="password" class="form-label">Heslo</label>
						<input type="password" class="form-control<?php if(isset($mistake['password'])){echo " is-invalid";} ?>" id="password" aria-describedby="passwordHelp" name="password">
						<div id="passwordHelp" class="form-text">Minimálne 5 znakov.</div>
						<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['password'])) ? " - ".$mistake['password'] : "";?>.</div>
					 </div>
					<fieldset>
						<legend aria-describedby="requiredHelp">Kontaktné údaje</legend>
						<div id="requiredHelp" class="form-text">Všetky údaje sú povinné.</div>
						<div class="mb-3">
							<label for="name" class="form-label">Meno</label>
							<input type="text" class="form-control<?php if(isset($mistake['name'])){echo " is-invalid";} ?>" name="name" id="name" value="<?php if (isset($name)) echo $name; ?>">
							<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['name'])) ? " - ".$mistake['name'] : "";?>.</div>
						</div>
						<div class="mb-3">
							<label for="last_name" class="form-label">Priezvisko</label>
							<input type="text" class="form-control<?php if(isset($mistake['last_name'])){echo " is-invalid";} ?>" name="last_name" id="last_name" value="<?php if (isset($last_name)) echo $last_name; ?>">
							<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['last_name'])) ? " - ".$mistake['last_name'] : "";?>.</div>
						 </div>
						 <div class="mb-3">
							<label for="street" class="form-label">Ulica</label>
							<input type="text" class="form-control<?php if(isset($mistake['street'])){echo " is-invalid";} ?>" id="street" name="street" value="<?php if (isset($street)) echo $street; ?>">
							<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['street'])) ? "- ".$mistake['street'] : "";?>.</div>
						 </div>
						 <div class="mb-3">
							<label for="house_number" class="form-label">Číslo domu</label>
							<input type="text" class="form-control<?php if(isset($mistake['house_number'])){echo " is-invalid";} ?>" id="house_number" aria-describedby="numberHelp" name="house_number" value="<?php if (isset($house_number)) echo $house_number; ?>">
							<div id="numberHelp" class="form-text">Napríklad: 24.</div>
							<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['house_number'])) ? " - ".$mistake['house_number'] : "";?>.</div>
						 </div>
						 <div class="mb-3">
							<label for="city" class="form-label">Mesto</label>
							<input type="text" class="form-control<?php if(isset($mistake['city'])){echo " is-invalid";} ?>" id="city" name="city"  value="<?php if (isset($city)) echo $city; ?>">
							<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['city'])) ? " - ".$mistake['city'] : "";?>.</div>
						 </div>
						 <div class="mb-3">
							<label for="psc" class="form-label">PSČ</label>
							<input type="text" class="form-control<?php if(isset($mistake['psc'])){echo " is-invalid";} ?>" id="psc" aria-describedby="pscHelp" name="psc"  value="<?php if (isset($psc)) echo $psc; ?>">
							<div id="pscHelp" class="form-text">Napríklad: 94901.</div>
							<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['psc'])) ? " - ".$mistake['psc'] : "";?>.</div>
						 </div>
						 
						 <div class="mb-3">
							<label for="mobile" class="form-label">Telefón</label>
							<input type="text" class="form-control<?php if(isset($mistake['mobile'])){echo " is-invalid";} ?>" id="mobile" aria-describedby="mailHelp" name="mobile"  value="<?php if (isset($mobile)) echo $mobile; ?>">
							<div id="mailHelp" class="form-text">Napríklad: 00421903223476.</div>
							<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['mobile'])) ? " - ".$mistake['mobile'] : "";?>.</div>
						 </div>
					</fieldset>
					<div class="mb-3 form-check">
						<input type="checkbox" class="form-check-input<?php if(false === $personal_info){echo " is-invalid";} ?>" id="Check1" name="check" <?php if(isset($_POST["check"])) echo " checked"?>>
						<label class="form-check-label" for="Check1">* Beriem na vedomie, že moje osobné údaje uvedené v tomto formulári môžu byť apartmánovým domom Liliana ďalej spracúvané na účely vybavenia mojej požiadavky, a to za podmienok a v súlade so Zásadami ochrany osobných údajov, s ktorými som sa dôkladne oboznámil(a).*</label>
						<div class="invalid-feedback">Prosím odsúhlaste spracovanie osobných údajov.</div>
					</div>
					<button name='odosli'type="submit" class="btn btn-primary">Zaregistruj sa</button>
				</form>
			</section>
		</div>
	<?php } ?>
</div>
<?php include('pata.php'); }?>