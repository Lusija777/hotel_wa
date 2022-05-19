<?php
session_start();
include('../funkcie_vseobecne.php');
include('../funkcie.php');
include('../database.php');
$user = find_user_from_session($mysqli, null, 'user');
	
$title = 'Zmena údajov používateľa - '.$user['name'].' '.$user['last_name'];
include('../hlavicka.php');
include('../nav.php');
$mistake = [];

?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<div class="row">
		<div class="col-2">
			<nav class="nav flex-column">
			  <a href="/projekt/user/user_objednavky.php?page=1" class="nav-link">Objednávky</a>
			  <a href="/projekt/user/zmena_udajov.php" class="nav-link">Zmena údajov</a>
			  <a href="/projekt/odhlasit.php" class="nav-link">Odhlás</a>
			</nav>
		</div>
		<?php
		if (isset($_POST['zmen'])) {
			$name = load_from_post('name');
			$last_name = load_from_post('last_name');
			$street = load_from_post('street');
			$house_number = load_from_post('house_number');
			$city = load_from_post('city');
			$psc = load_from_post('psc');
			$mobile = load_from_post('mobile');
			
			if ($name === null || $name == ''){$mistake["name"] = "nezadali ste meno";}
			if (strlen($name) >= 65){$mistake["name"] = "zlá dĺžka mena";}
			if (strlen($last_name) >= 65){$mistake["last_name"] = "zlá dĺžka priezviska";}
			if (strlen($street) >= 65){$mistake["street"] = "zlá dĺžka ulice";}
			if (strlen($city) >= 65){$mistake["city"] = "zlá dĺžka mesta";}
			
			if ($last_name === null || $last_name == ''){$mistake["last_name"] = "nezadali ste priezvisko";}
			if(!is_numeric($house_number)){$mistake["house_number"] = "nezadali ste správny formát";}
			if ($house_number === null || $house_number == ''){$mistake["house_number"] = "nezadali ste číslo domu";}
			
			if ($street === null || $street == ''){$mistake["street"] = "nezadali ste ulicu";}
			if ($city === null || $city == ''){$mistake["city"] = "nezadali ste mesto";}
			
			if (!(preg_match('/^[0-9]{5}$/', $psc))) { $mistake["psc"] = "nezadali ste správny formát";}
			if ($psc === null || $psc == ''){$mistake["psc"] = "nezadali ste poštové smerovacie číslo";}
			
			if (!(preg_match('/^00421[0-9]{9}$/', $mobile))) { $mistake["mobile"] = "nezadali ste správny formát";}
			if ($mobile === null || $mobile == ''){$mistake["mobile"] = "nezadali ste telefón";}
			
		}
		if (isset($_POST['zmen']) && empty($mistake)){
			// pridat do clientov a userov
			update_user($mysqli, $user['id'], $name, $last_name, $street, $house_number, $city, $psc, $mobile);
			?>
				<div class="col-10">
					<div class="alert alert-success">Vaše údaje boli úspešne zmenené.</div>
				</div>
			<?php
		}
		else{ ?>
			<div class="col-10">
				<section>
					<form method="post">
						<fieldset>
							<legend aria-describedby="requiredHelp">Kontaktné údaje</legend>
							<div id="requiredHelp" class="form-text">Všetky údaje sú povinné.</div>
							<div class="mb-3">
								<label for="name" class="form-label">Meno</label>
								<input type="text" class="form-control<?php if(isset($mistake['name'])){echo " is-invalid";} ?>" name="name" id="name" value="<?php echo (isset($name)) ? $name : $user['name']; ?>">
								<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['name'])) ? " - ".$mistake['name'] : "";?>.</div>
							</div>
							<div class="mb-3">
								<label for="last_name" class="form-label">Priezvisko</label>
								<input type="text" class="form-control<?php if(isset($mistake['last_name'])){echo " is-invalid";} ?>" name="last_name" id="last_name" value="<?php echo (isset($last_name)) ? $last_name : $user['last_name']; ?>">
								<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['last_name'])) ? " - ".$mistake['last_name'] : "";?>.</div>
							 </div>
							 <div class="mb-3">
								<label for="street" class="form-label">Ulica</label>
								<input type="text" class="form-control<?php if(isset($mistake['street'])){echo " is-invalid";} ?>" id="street" name="street" value="<?php echo (isset($street)) ? $street : $user['street']; ?>">
								<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['street'])) ? " - ".$mistake['street'] : "";?>.</div>
							 </div>
							 <div class="mb-3">
								<label for="house_number" class="form-label">Číslo domu</label>
								<input type="text" class="form-control<?php if(isset($mistake['house_number'])){echo " is-invalid";} ?>" id="house_number" name="house_number" value="<?php echo (isset($house_number)) ? $house_number : $user['house_number']; ?>">
								<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['house_number'])) ? " - ".$mistake['house_number'] : "";?>.</div>
							 </div>
							 <div class="mb-3">
								<label for="city" class="form-label">Mesto</label>
								<input type="text" class="form-control<?php if(isset($mistake['city'])){echo " is-invalid";} ?>" id="city" name="city"  value="<?php echo (isset($city)) ? $city : $user['city']; ?>">
								<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['city'])) ? " - ".$mistake['city'] : "";?>.</div>
							 </div>
							 <div class="mb-3">
								<label for="psc" class="form-label">PSČ</label>
								<input type="text" class="form-control<?php if(isset($mistake['psc'])){echo " is-invalid";} ?>" id="psc" aria-describedby="pscHelp" name="psc"  value="<?php echo (isset($psc)) ? $psc : $user['post_code']; ?>">
								<div id="pscHelp" class="form-text">Napríklad: 94901.</div>
								<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['psc'])) ? " - ".$mistake['psc'] : "";?>.</div>
							 </div>
							 
							 <div class="mb-3">
								<label for="mobile" class="form-label">Telefón</label>
								<input type="text" class="form-control<?php if(isset($mistake['mobile'])){echo " is-invalid";} ?>" id="mobile" aria-describedby="mailHelp" name="mobile"  value="<?php echo (isset($mobile)) ? $mobile : $user['mobile']; ?>">
								<div id="mailHelp" class="form-text">Napríklad: 00421903223476.</div>
								<div class="invalid-feedback">Prosím vyplňte tento údaj<?php echo (isset($mistake['mobile'])) ? " - ".$mistake['mobile'] : "";?>.</div>
							 </div>
						</fieldset>
						<button name='zmen'type="submit" class="btn btn-primary">Zmeň údaje</button>
					</form>
				</section>
			</div>
		<?php } ?>
	</div>
	
</div>
<?php include('../pata.php'); ?>