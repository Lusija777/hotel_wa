<?php // mam stiahnuty xampp verzie 8.1.2 -0
// admin heslo:liliana321 email:liliana@liliana.sk
$mysqli = new mysqli('localhost', 'root', '', 'hotel');
if ($mysqli->connect_errno) {
	echo '<p class="chyba">Nepodarilo sa pripojiť! (' . $mysqli->connect_errno . ' - ' . $mysqli->connect_error . ')</p>';
} else {
	$mysqli->query("SET CHARACTER SET 'utf8'");
}

?> 