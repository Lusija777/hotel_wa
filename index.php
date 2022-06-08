<?php
session_start();
include('database.php');
include('funkcie_vseobecne.php');
include('funkcie.php');
$title = 'Ubytovanie LILIANA';
include('hlavicka.php');
include('nav.php');
?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<div class="row">
		<div class="col-6">
			<h3>O hoteli Liliana</h3>
			<p>Apartmánový dom LILIANA ponúka luxusné ubytovanie vo Vysokých Tatrách za dostupné ceny. Nachádza sa v prekrásnom prostredí rekreačnej zóny v Tatranskej Štrbe.</br>
			V blízkosti apartmánového domu je reštaurácia, tenisové kurty, cvičný lyžiarsky vlek a stanica zubačky s prepojením na naj navštevovanejšie stredisko Vysokých Tatier, Štrbské Pleso. Na prenájom je k dispozícii 9 individuálne a nadštandardne zariadených dvoj až sedemmiestnych apartmánov vo výmere 25 – 64 m2.</p>
			<p>Apartmány LILIANA sú vybavené sprchou, WC a väčšina aj balkónom či kuchynkou. Každý apartmán má parkovacie miesto na vyhradenom parkovisku.</p>
			<p>Apartmánový dom LILIANA privítal prvých hostí v lete 2007.</p>
		</div>
		<div class="col-6">
			<div class="lightgallery">
				<a href="obrazky/i1.jpg" style="text-decoration: none;">
					<img width="300" height="100" class="img-thumbnail gallery-image" alt="Apartmány Liliana" src="obrazky/i1.jpg"/>
				</a>
				<a href="obrazky/i2.jpg" style="text-decoration: none;">
					<img width="300" height="100" class="img-thumbnail gallery-image" alt="Apartmány Liliana" src="obrazky/i2.jpg"/>
				</a>
				<a href="obrazky/i3.jpg" style="text-decoration: none;">
					<img width="300" height="100" class="img-thumbnail gallery-image" alt="Apartmány Liliana" src="obrazky/i3.jpg"/>
				</a>
				<a href="obrazky/i4.jpg" style="text-decoration: none;">
					<img width="300" height="100" class="img-thumbnail gallery-image" alt="Apartmány Liliana" src="obrazky/i4.jpg"/>
				</a>
			</div>
		</div>
	</div>
</div>
<?php include('pata.php'); ?>