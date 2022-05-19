<?php
session_start();
include('database.php');
include('funkcie_vseobecne.php');
$title = 'Kontakt';
include('funkcie.php');
include('hlavicka.php');
include('nav.php');
?>
<div class="container">
	<header>
		<h1><?php echo $title; ?></h1>
	</header>
	<hr>
	<div class="row">
		<div class="col-lg-6">
			<h3>Poloha</h3>
					<p>Tatranská Štrba sa nachádza na ceste medzi Liptovským Mikulášom a Popradom, pár kilometrov od diaľnice D1 a iba 18 km od medzinárodného letiska Poprad-Tatry. So zvyškom Vysokých Tatier je okrem ciest spojená aj ozubnicovou železnicou.</br>

					K apartmánovému domu LILIANA je veľmi jednoduchý prístup priamo z cesty č. 18 (Žilina-Poprad). V Tatranskej Štrbe treba odbočiť na smer Štrbské Pleso a prvou odbočkou doprava. Táto cesta vedie popri hoteloch Konvalinka a Narcis priamo do areálu apartmánového domu. Pri použití diaľnice D1 treba zísť na diaľničnom výjazde Štrba a pokračovať smerom na Štrbské Pleso do Tatranskej Štrby.</br>

					Vo vzdialenosti 10 minút chôdze od apartmánového domu je medzinárodná rýchliková železničná stanica, odkiaľ sa dá pohodlne dostať zubačkou priamo na Štrbské Pleso.</p>

					<p>GPS: 49°5' 10" N, 20° 4' 27"E</p>

			<h3>Kontakt</h3>
				<p>Email: liliana@liliana.sk</br>
				Telefón: 0903 223 476</p>

			<h3>Adresa</h3>
				<p>Apartmánový dom Liliana</br>
				Rekreačná 1538</br>
				059 41 Tatranská Štrba</p>
		</div>
		<div class="col-lg-6">
			<div class="ratio ratio-16x9">
				<iframe src="https://www.openstreetmap.org/export/embed.html?bbox=20.053224563598636%2C49.07951633715538%2C20.08609771728516%2C49.096435687862986&amp;layer=mapnik" style="border: 1px solid black"></iframe>
			</div>

		</div>
	</div>
</div>

<?php include('pata.php'); ?>