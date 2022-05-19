<?php
function print_room_number_of_people_options($room, $number_of_people) {
	for($i = 1; $i <= $room['number_of_beds']; $i++) {
		echo "<option value='$i'";
		if ($i == $number_of_people) {
			echo ' selected';
		}
		echo ">$i</option>\n";
	}
	$j = 1;
	for($i = $room['number_of_beds']+1; $i <= $room['number_of_beds']+$room['extra_bed']; $i++) {
		echo "<option value='$i'";
		if ($i == $number_of_people) {
			echo ' selected';
		}
		echo ">$i (z toho $j prístelka)</option>\n";
		$j++;
	}
}
function find_rooms($mysqli, $room_id = null){ // najde vsetky izby v ponuke a udaje o nich
	//$sql = "SELECT * FROM room, photo WHERE room.id = photo.room_id "; // definuj dopyt
	$sql = "
	SELECT room.id, room.price_for_night, room.number_of_beds, room.extra_bed, room.name, room.bathroom, room.kitchen, room.balcony, room.wifi, room.main_photo_id, photo.id as photo_id, photo.path as photo_path 
	FROM room LEFT JOIN photo ON room.id = photo.room_id"; // definuj dopyt
	if (null !== $room_id) {
		$sql .= " WHERE room.id = $room_id"; 
	}
	if (isset($_POST['nazov2'])) {
		$sql .= ' ORDER BY name DESC'; 
	}
	elseif (isset($_POST['cena1'])) {
		$sql .= ' ORDER BY price_for_night ASC'; 
	}
	elseif (isset($_POST['cena2'])) {
		$sql .= ' ORDER BY price_for_night DESC';
	}
	else {
		$sql .= ' ORDER BY name ASC';
	}
	return map_room_result($mysqli, $sql);
}

function map_room_result($mysqli, $sql) { // usporiada udaje o izbe do pola
	$result = sql($mysqli, $sql);
	$rooms = [];
	while ($row = $result->fetch_assoc()) {
		$photo = [
			'id' => $row['photo_id'],
			'path' => $row['photo_path'],
		];
		if (array_key_exists($row['id'], $rooms)) {
			$rooms[$row['id']]['photos'][$photo['id']] = $photo;
		}
		else {
			$room = [
				'id' => $row['id'],
				'price_for_night' => $row['price_for_night'],
				'number_of_beds' => $row['number_of_beds'],
				'extra_bed' => $row['extra_bed'],
				'name' => $row['name'],
				'bathroom' => $row['bathroom'],
				'kitchen' => $row['kitchen'],
				'balcony' => $row['balcony'],
				'wifi' => $row['wifi'],
				'main_photo_id' => $row['main_photo_id'],
				'photos' => [$photo['id'] => $photo],
			];
			$rooms[$row['id']] = $room;
		}
	}
	return $rooms;
}
function find_room($mysqli, $room_id) {
	$rooms = find_rooms($mysqli, $room_id);
	$room = reset($rooms);
	return false === $room ? null : $room;
}

function print_rooms(array $rooms, bool $with_gallery, bool $with_button, array $daterange, $number_of_people = null) { // vypisuje izby, s galeriou, s tlacidlom na rezervovanie
	$numRooms= count($rooms);
	$j = 0;
	foreach ($rooms as $room) { ?>
		<div class="row">
			<div class="col-lg-6 order-lg-<?= ($j%2 == 0) ? 1 : 2 ?>">
				<h4><?= $room['name']; ?></h4>
				<hr>
				<table class="table table-striped table-hover table-bordered">
					<tr>
					  <th>Počet postelí</th>
					  <td><?= $room['number_of_beds']; ?></td>
					</tr>
					<tr>
					  <th>Počet prístelok</th>
					  <td><?= $room['extra_bed']; ?></td>
					</tr>
					<tr>
					  <th>Kúpeľňa</th>
					  <td><?php echo ($room['bathroom']) ? 'Áno' :  'Nie'; ?></td>
					</tr>
					<tr>
					  <th>Kuchyňa</th>
					  <td><?php echo ($room['kitchen']) ? 'Áno' : 'Nie'; ?></td>
					</tr>
					<tr>
					  <th>Balkón</th>
					  <td><?php echo ($room['balcony']) ? 'Áno' : 'Nie'; ?></td>
					</tr>
					<tr>
					  <th>Internetové pripojenie</th>
					  <td><?php echo ($room['wifi']) ? 'Áno' : 'Nie'; ?></td>
					</tr>
				</table>
				<?php if (true === $with_gallery) {?>
					<div class="lightgallery">
						<?php 
						$i = 1;
						foreach ($room['photos'] as $photo) { ?>
							<a href="/projekt<?= $photo['path']; ?>" style="text-decoration: none;">
								<img width="150" height="150" class="img-thumbnail gallery-image" alt="<?= $room['name']; ?> - fotka <?= $i; ?>" src="/projekt<?= $photo['path']; ?>"/>
							</a>
						
						<?php
							$i++;
						} ?>
					</div>
				<?php 
				}

				$nights = get_nights_from_daterange($daterange);
				if (true === $with_button) {?>
					<div class="d-grid my-2 mb-lg-0">
						<a href="/projekt/objednavka.php?room_id=<?= $room['id']; ?>&daterange=<?= $daterange[0]; ?>+do+<?= $daterange[1]; ?>&number_of_people=<?= $number_of_people; ?>" class="btn btn-primary btn-lg link-light">Rezervuj - <span><?= count_room_price($room, $nights); ?><?= $nights > 1 ? '' : ' za noc'?></span></a>
					</div>
				<?php }
				else { ?>
					<div class="d-grid my-2 mb-lg-0">
						<div class="badge bg-success p-3"><?= count_room_price($room, $nights); ?><?= $nights > 1 ? '' : ' za noc'?></div>
					</div>
				<?php } ?>
			</div>
			<div class="col-lg-6 order-lg-<?= ($j%2 == 0) ? 2 : 1 ?>">
				<?php
				$main_photo = $room['photos'][$room['main_photo_id']];
				?>
				<div class="h-100">
					<img class="w-100" height="450" alt="<?= $room['name']; ?>" src="/projekt<?= $main_photo['path']; ?>"/>
				</div>
			</div>
		</div>
		<?php
		$j++;
		if($j < $numRooms) {
			echo "<hr>";
		}
	}
}
function count_room_price($room, $nights) {
	return formatPrice($room['price_for_night'] * $nights);
}
function login($mysqli, $password, $email) { // kontroluje ci je dany uzivatel zaregistovany
	$sql = "SELECT id, role, password FROM user WHERE user.email = '$email'";
	$result = sql($mysqli, $sql);
	$row = $result->fetch_assoc();
	//echo password_hash("liliana321", PASSWORD_DEFAULT);
	if (null === $row || !password_verify($password, $row['password'])) {
		return null;
	}
	return $row;
}
function find_available_rooms($mysqli, $daterange, $number_of_people) { // hlada volne izby v danom termine a pre dany pocet ludi
	$sql = "SELECT room.id, room.price_for_night, room.number_of_beds, room.extra_bed, room.name, room.bathroom, room.kitchen, room.balcony, room.wifi, room.main_photo_id, photo.id as photo_id, photo.path as photo_path
			FROM room 
			LEFT JOIN (
				SELECT room.id FROM `room` LEFT JOIN `order` ON room.id = `order`.room_id 
				WHERE 
					(`order`.to > '$daterange[0]' AND `order`.from <= '$daterange[0]') OR 
					(`order`.to >= '$daterange[1]' AND `order`.from < '$daterange[1]')
			) occupied_room ON room.id = occupied_room.id
			LEFT JOIN photo ON room.id = photo.room_id		
			WHERE 
				occupied_room.id IS NULL AND 
				(room.number_of_beds + room.extra_bed) >= $number_of_people";
	return map_room_result($mysqli, $sql);
}

function all_orders($mysqli, $page, $limit, $admin, $id = null) { // vypise vsetky objednavky, bud pre admina alebo pouzivatela
	$sql = "SELECT room.id as room_id, room.price_for_night, room.name as room_name, `order`.user_id as client_id, `order`.id, `order`.number_of_people, `order`.from, `order`.to, `order`.price, user.name, user.last_name, user.city, user.email, user.mobile, user.role
			FROM `order`
			LEFT JOIN room ON `order`.room_id = room.id
			LEFT JOIN user ON `order`.user_id = user.id";
	if(null !== $id){ 
		$sql .= " WHERE user.id = $id";
	}
	$page = $limit*($page -1);
	$sql .= " ORDER BY `order`.id DESC";
	$sql .= " LIMIT $page, $limit";
	$result = sql($mysqli, $sql);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-hover table-bordered">
			<tr>
			  <th>Číslo obj.</th>
			  <th>Meno</th>
			  <th>Priezvisko</th>
			  <th>Email</th>
			  <th>Telefón</th>
			  <th>Počet osôb</th>
			  <th>Názov apartmánu</th>
			  <th>Od</th>
			  <th>Do</th>
			  <th>Cena za noc</th>
			  <th>Celková cena</th>
			  
			  <?php if (0 !== $admin){ ?>
				<th></th>
			  <?php } ?>
			</tr>
		<?php
		while ($row = $result->fetch_assoc()) {
			if ($row['role'] != 'admin'){
				?>
				<tr>
				  <td><?= $row['id'];?></td>
				  <td><?= $row['name'];?></td>
				  <td><?= $row['last_name'];?></td>
				  <td><?= $row['email'];?></td>
				  <td><?= $row['mobile'];?></td>
				  <td><?= $row['number_of_people'];?></td>
				  <td><?= $row['room_name'];?></td>
				  <td><?= $row['from'];?></td>
				  <td><?= $row['to'];?></td>
				  <td><?= $row['price_for_night'];?></td>
				  <td><?= $row['price'];?></td>
				  <?php 
				  if (0 !== $admin){
					  ?>
					  <td><a href="/projekt/vymaz_objednavku.php?id=<?= $row['id'];?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3 text-danger" viewBox="0 0 16 16">
						  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
						  </svg></a></td>
				  <?php }?>
				  
				</tr>
			<?php }
		}?>
		</table>
	</div>
<?php
}
function add_to_orders($mysqli, $id, $room_id, $number_of_people, array $daterange) { // pridava objednavku do tabulky
	$sql_price = "SELECT room.price_for_night FROM room WHERE room.id = '$room_id'";
	$result_price = sql($mysqli, $sql_price);
	$price_for_night = $result_price->fetch_column(0);
	$nights = (new DateTime($daterange[1]))->diff(new DateTime($daterange[0]))->format("%a");
	$all_price = $price_for_night*$nights;
	$from = $daterange[0];
	$to = $daterange[1];
	
	$sql = "SELECT user.id 
			FROM user
			WHERE user.id = $id";
	$result = sql($mysqli, $sql);
	$id = $result->fetch_column(0);
	if (null === $id || false === $id){
		
		$result = sql($mysqli, "SELECT LAST_INSERT_ID()");
		$id = $result->fetch_column(0);
	}

	$sql_add_order = "INSERT INTO `order`(`user_id`, `room_id`, `number_of_people`, `from`, `to`, `price`) 
						VALUES ($id,$room_id,$number_of_people,'$from','$to',$all_price)";
	$add_order_result = $mysqli->query($sql_add_order);
}
function add_to_users($mysqli, $name, $last_name, $street, $house_number, $city, $psc, $email, $mobile, $password) { // pridava pouzivatela po registracii do tabulky, koduje heslo
	$pass = password_hash("$password", PASSWORD_DEFAULT);
	$sql_add_user = "INSERT INTO `user`(`id`, `email`, `password`, `role`, `name`, `last_name`, `street`, `house_number`, `city`, `post_code`, `mobile`)
						VALUES ('','$email','$pass','user','$name','$last_name','$street','$house_number','$city','$psc','$mobile')";
	$add_user_result = $mysqli->query($sql_add_user);
	$result = sql($mysqli, "SELECT LAST_INSERT_ID()");
	$id = $result->fetch_column(0);
	return $id;
}
function check_if_order_exists($mysqli, $room_id, $from, $to) {
	$sql = "SELECT `order`.id 
			FROM `order` 
			WHERE `order`.room_id = '$room_id' AND 
				((`order`.to > '$from' AND `order`.from <= '$from') OR 
					(`order`.to >= '$to' AND `order`.from < '$to'))";
	$result = sql($mysqli, $sql);
	
	if ($mysqli->affected_rows > 0){
		return true;
	}
	return false;
}
function check_number_of_people($mysqli, $room_id, $number_of_people) {
	$sql = "SELECT id 
			FROM room 
			WHERE room.id = '$room_id' AND (room.number_of_beds + room.extra_bed) >= $number_of_people";
	$result = sql($mysqli, $sql);
	if ($mysqli->affected_rows > 0){
		return true;
	}
	return false;
}
function remove_order($mysqli, $order_id) {
	$sql = "DELETE FROM `order` WHERE id = $order_id";
	$result = sql($mysqli, $sql);
	if ($mysqli->affected_rows > 0){
		return true;
	}
	return false;
}

function all_users($mysqli, $page, $limit) { // vypisuje vsetkych pouzivatelov, pre admina
	$sql = "SELECT user.id, user.name, user.last_name, user.street, user.house_number, user.post_code, user.city, user.email, user.mobile, user.role
			FROM user";
	
	$page = $limit*($page -1);
	$sql .= " ORDER BY user.id DESC";
	$sql .= " LIMIT $page, $limit";
	$result = sql($mysqli, $sql);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-hover table-bordered">
			<tr>
			  <th>Číslo klienta</th>
			  <th>Meno</th>
			  <th>Priezvisko</th>
			  <th>Email</th>
			  <th>Telefón</th>
			  <th>Ulica</th>
			  <th>Číslo domu</th>
			  <th>Mesto</th>
			  <th>PSČ</th>
			  
			</tr>
		<?php
		while ($row = $result->fetch_assoc()) {
			if ($row['role'] != 'admin'){
				?>
				<tr>
				  <td><?= $row['id'];?></td>
				  <td><?= $row['name'];?></td>
				  <td><?= $row['last_name'];?></td>
				  <td><?= $row['email'];?></td>
				  <td><?= $row['mobile'];?></td>
				  <td><?= $row['street'];?></td>
				  <td><?= $row['house_number'];?></td>
				  <td><?= $row['city'];?></td>
				  <td><?= $row['post_code'];?></td>
				</tr>
			<?php } 
		}?>
		</table>
	</div>
<?php
}
function print_user($mysqli, $id){ // vypisuje uzivatela, ktory si objednava izbu
	$sql = "SELECT *
			FROM user 
			WHERE user.id = $id";
	$result = sql($mysqli, $sql);
	$row = $result->fetch_assoc()
	?>
	<div class="table-responsive">
		<table class="table table-striped table-hover table-bordered">
			<tr>
			  <th>Meno</th>
			  <td><?= $row['name'];?></td>
			</tr>
			<tr>
			  <th>Priezvisko</th>
			  <td><?= $row['last_name'];?></td>
			</tr>
			<tr>
			  <th>Email</th>
			  <td><?= $row['email'];?></td>
			</tr>
			<tr>
			  <th>Telefón</th>
			  <td><?= $row['mobile'];?></td>
			</tr>
			<tr>
			  <th>Ulica</th>
			  <td><?= $row['street'];?></td>
			</tr>
			<tr>
			  <th>Číslo domu</th>
			  <td><?= $row['house_number'];?></td>
			</tr>
			<tr>
			  <th>Mesto</th>
			  <td><?= $row['post_code'];?></td>
			</tr>
		</table>
	</div>
	<?php
}
function find_user($mysqli, $id){ //hlada udaje o pouzivatelovi, ked je nastaveny session[user]
	$sql = "SELECT id, role, name, last_name, city, street, house_number, post_code, mobile
			FROM user 
			WHERE user.id= $id";
	$result = sql($mysqli, $sql);
	$row = $result->fetch_assoc();
	return $row;
}
function update_user($mysqli, $user_id, $name, $last_name, $street, $house_number, $city, $psc, $mobile) { 
	$sql = "UPDATE user 
			SET name='$name',last_name='$last_name',street='$street',house_number=$house_number,city='$city',post_code='$psc',mobile='$mobile' 
			WHERE user.id = $user_id";
	$result = sql($mysqli, $sql);
}
?>


