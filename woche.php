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
				<h2 class="page-header">Wochenübersicht
					<small><?php echo $current->Zeit;?></small>
				</h2>
			</div>
		</div>
		<!-- /.row -->

		<!-- Data Row -->
		<div class="row">
			<?php
				$week = new TextColumn(4, 'Titel <span class="glyphicon glyphicon-search"></span>', '', 'Mein Projekt');
				$week->AddJsonTableRecursive('data/week.json');
				print $week;
				print new TextColumn(4, 'Anderer Titel<span class="badge">Hallo</span>' , '', 'text...');
			?>
			<div class="col-md-4 portfolio-item">
				<table  class="table table-condensed table-striped">
					<caption>Diese Woche</caption>
					<thead><tr><th>Temperatur</th><th></th></tr></thead>
					<tbody>
						<tr><td>Max</td><td>12,3 °C um 03.04. 16:18</td></tr>
						<tr><td>Min</td><td>2,5 °C um 02.04. 07:32</td></tr>
					</tbody>
					<thead><tr><th>Feuchte</th><th></th></tr></thead>
					<tbody>
						<tr><td>Max</td><td>68% am 03.04. 16:18</td></tr>
						<tr><td>Min</td><td>53% am 02.04. 07:32</td></tr>
					</tbody>
					<thead><tr><th>Einzelwerte</th><th></th></tr></thead>
					<tbody>
						<tr><td>Wind</td><td>43 km/h am 03.04. 02:05</td></tr>
						<tr><td>Regen</td><td>12 mm diese Woche</td></tr>
						<tr><td>Max Regenrate</td><td>2,5mm/h am 03.04. 16:18</td></tr>
					</tbody>
				</table>
			</div>
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
