<?php
date_default_timezone_set('Europe/Bratislava');

function sql($mysqli, $sql) {
	if ($result = $mysqli->query($sql)) {
		return $result;
	}
	else {
    	echo '<p class="chyba">Nastala chyba pri získavaní údajov z DB.</p>' . "\n";
    }
}
function osetri($co) {
	return trim(strip_tags($co));
}
function get_nights_from_daterange($daterange) {
	if ([] !== $daterange) {
		return (new DateTime($daterange[1]))->diff(new DateTime($daterange[0]))->format("%a"); 
	}
	else {
		return 1;
	}
}
function formatPrice(string $price) {
	return number_format((float)$price, 2, ',', '') ."&euro;";
}
function redirect($url, $statusCode = 303) { //presmerovanie na inu url
   header('Location: ' . $url, true, $statusCode);
   die();
}
function load_from_post($key) {
	if (isset($_POST[$key])) {
		return osetri($_POST[$key]); 
	}
	return null;
}
function load_from_get($key) {
	if (isset($_GET[$key])) {
		return osetri($_GET[$key]); 
	}
	return null;
}
function hack_attempt() {
	?>
	<div class="alert alert-danger">Hackovanie URL nie je povolene.</div>
	<?php 
}
function wrong_values_attempt() {
	?>
	<div class="alert alert-warning">Nepodarilo sa vyhľadať dostupnosť.</div>
	<?php
}
function paginate(int $page) { //strankovanie
	?>
	<nav>
	    <ul class="pagination justify-content-center">
	   
		<li class="page-item">
		  <a class="page-link" href="?page=<?php echo ($page > 1) ? $page-1 : 1;?>" aria-label="Previous">
			<span>&laquo;</span>
		  </a>
		</li>
	    
		<?php if ($page > 1){?>
			<li class="page-item"><a class="page-link" href="?page=<?=$page-1?> "><?=$page-1?></a></li>
		<?php }?>
		<li class="page-item"><a class="page-link" href="?page=<?=$page?>"><?=$page?></a></li>
		<li class="page-item"><a class="page-link" href="?page=<?=$page+1?>"><?=$page+1?></a></li>
		<li class="page-item">
		  <a class="page-link" href="?page=<?=$page+1?>" aria-label="Next">
			<span>&raquo;</span>
		  </a>
		</li>
	  </ul>
	</nav>
	<?php
}
function check_email_in_database($mysqli, $email) {
	$sql = "SELECT user.id
			FROM user 
			WHERE user.email = '$email'";
	$result = sql($mysqli, $sql);
	$id = $result->fetch_column(0);
	if (null === $id || false === $id){
		return false;
	}
	return true;
}

function find_user_from_session($mysqli, $targetPath, $expectedRole = null) {
	if(!isset($_SESSION['user'])) {
		$user = null;
	}
	else {
		$user = find_user($mysqli, $_SESSION['user']);
	}
	if ($user === null) {
		if (null === $targetPath) {
			$targetPath = 'login.php';
		}
		redirect($targetPath);
	}
	
	if (null !== $expectedRole) {
		if ($user['role'] !== $expectedRole) {
			if ($user['role'] === 'user') {
				redirect('user.php');
			}
			if ($user['role'] === 'admin') {
				redirect('admin.php');
			}
		}
	}
	
	return $user;
}
?>