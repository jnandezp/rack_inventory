<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Foundation Starter Template</title>
	<!-- Compressed CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/css/foundation.min.css" />
	<link rel="stylesheet" href="../../assets/css/custom.css" />
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">


</head>
<body>
	<?php $this->load->view($navbar); ?>
	<div class="main-container">
		<div class="grid-x">
			<div class="columns small-12 text-center">
				<h1>Crear rack</h1>
				<hr>
			</div>
		</div>

		<div class="row">
			<?php echo form_open('inventory/addRack'); ?>
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="medium-6 cell">
						<label>Nivel
							<input id="input-niveles" type="number" placeholder="2" min="1" name="niveles">
						</label>
					</div>
					<div class="medium-6 cell">
						<label>Ubicaciones
							<input id="input-ubicaciones" type="number" placeholder="4" min="1" name="ubicaciones">
						</label>
					</div>
				</div>
			</div>
			<div class="text-right grid-container">
				<a class="button secondary" onclick="clean()"> Deshacer cambios </a>
				<input type="submit" name="submit" class="button primary" value="Agregar Rack" />
			</div>
		</form>
	</div>

	<div class="grid-container">
		<h2>
			Listado de racks
		</h2>
		<table>
			<thead>
				<tr>
					<th>Nº</th>
					<th>Nombre</th>
					<th class="text-center">Niveles</th>
					<th class="text-center">Posiciones</th>
					<th></th>

				</tr>
			</thead>
			<tbody>
				<?php foreach ($rackList as $rack): ?>
					<tr>
						<td>
							<?= $rack->id; ?>
						</td>
						<td>
							<?= $rack->name; ?>
						</td>
						<td class="text-center">
							<?= $rack->niveles; ?>
						</td>
						<td class="text-center">
							<?= $rack->ubicaciones; ?>
						</td>
						<td class="text-center">
							<a href="<?php echo site_url('inventory/detail/'.$rack->id) ?>" class="button primary delete-rack">
								<i class="fas fa-search"></i>								
							</a>
							<a href="<?php echo site_url('inventory/delete/'.$rack->id) ?>" class="button alert delete-rack" onclick="return confirm('¿Vaz a eliminar este Rack?');">
								<i class="fas fa-trash"></i>
							</a>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>




<!-- <script src="js/vendor/jquery.js"></script> -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Compressed JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/js/foundation.min.js"></script>
<script>
	$(document).foundation();

	function clean() {
		$('input#input-niveles').val('');
		$('input#input-ubicaciones').val('');
	}

</script>

</body>
</html>