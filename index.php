<!DOCTYPE html>
<html lang="de">
<head>
	<?php
		include_once ('header.php');
		include_once ('controller.php');
		include_once ('checkSSL.php');
		checkIsSSL(false);
		$current = json_decode(file_get_contents('data/current.json'));
	?>
</head>
<body>
	<!-- Navigation -->
	<?php include_once('nav.php'); ?>

	<!-- Page Content -->
	<div class="container">

		<!-- Page Header -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Aktuelle Werte
					<small><?php echo $current->Zeit;?></small>
				</h2>
			</div>
		</div>
		<!-- /.row -->

		<!-- Data Row -->
		<div class="row">
			<?php
				//print new TextColumn(4, 'Titel <span class="glyphicon glyphicon-search"></span>', 'Mein Projekt');
				$gauges = new TextColumn(8, 'aktuelle Ablesewerte');
				$gauges->AddGauge('barometer', 960, 1060, 'hPa', 1020);
				$gauges->AddGauge('thermometer', -40, 40, '°C', 18);
				$gauges->AddGauge('hygrometer', 0, 100, '% rel.', 62);
				print $gauges;
				//print new TextColumn(4, 'Anderer Titel<span class="badge">Hallo</span>' , 'text...');
				$elem1 = new TextColumn(4, 'Stationsdaten');
				$elem1->AddFlatTable('data/station.json');
				print $elem1;
			?>
		</div>
		<!-- /.row -->

		<!-- Data Row -->
		<div class="row">
			<?php
				$content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.';
				$contr1 = new TextColumn(4, 'Regen');
				$contr1->addImage('data/dayrain.png');
				$radar = json_decode(file_get_contents('data/radar.json'));
				$contr1->addImage($radar->Radarbild, 'Radarbild DWD', $radar->radarUrl); // 2bswitched on golive $radar->Radarbild, 
				print $contr1;
				$contr2 = new TextColumn(4, 'Windrichtung <small>vektoriell</small>');
				$contr2->addImage('data/daywindvec.png');
				print $contr2;
				$contr3 = new TextColumn(4, 'Übersicht');
				$contr3->AddFlatTable('data/current.json');
				print $contr3;
			?>
		</div>

		<!-- Data Row -->
		<div class="row">
			<?php
				$contr4 = new TextColumn(12, 'Eltern', 'https://nipp.de', 'Parenttext.');
				$nested1 = new TextColumn(4, 'Kind', '', 'Childtext.');
				$nested1->AddText($content);
				$nested1->AddImage('data/dayradiation.png');
				$nested2 = new TextColumn(4, 'Nochn Kindlein');
				$nested2->AddJsonTable('data/MonthMaxMin.json');
				$contr4->Append($nested1);
				$contr4->Append($nested2);
				print $contr4;
				
			?>
		</div>
		<!-- /.row -->
		<!--?php include_once('pagination.php'); ?-->
		<hr>
		<!-- Footer -->
		<?php include_once('footer.php'); ?>
	</div>
	<!-- /.container -->
</body>
</html>
