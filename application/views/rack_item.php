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
	<link rel="stylesheet" href="../../../assets/css/custom.css" />
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">


</head>
<body>
	<?php $this->load->view($navbar); ?>
	<div class="main-container" style="margin: 1rem;">

		<div class="">
			<div class="columns small-12 text-center">
				<h1>Rack <?= $dataRack['id'] ?></h1>
				<hr>
			</div>
			<div class="row">
				<div class="columns">
					<div class="table-scroll">
						<table style="margin:auto;">
							<thead>
								<tr>
									<th style="min-width:80px"></th>
									<?php for ($i=0; $i < $dataRack['ubicaciones']; $i++): ?>
										<th class="text-center" class="width-cell">
											<?= $letter[$i] ?>
										</th>
									<?php endfor ?>
								</tr>
							</thead>
							<tbody>

								<?php for ($i=$dataRack['niveles']; $i > 0; $i--) : ?>
									<tr>
										<td class="text-center">
											<?= 'N'.$i ?>
										</td>
										<?php foreach ($detail as $detalle): ?>
											<?php if($detalle->nivel == $i): ?>
												<td class="text-center width-cell rack-item" data-id-item="<?= $detalle->id ?>">
													<div class="row">
														<img src="../../../assets/img/box.png" class="box-pallet">
													</div>
													<div class="row">
														<span class="rack-item-value">
															<?= $detalle->value; 	?>
														</span>
													</div>
												</td>
											<?php endif ?>
										<?php endforeach ?>
									</tr>    		
								<?php endfor ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>



	</div>



	<div class="reveal" id="modalChengueValue" data-reveal data-id-save="">
		<h1>Modificar valor</h1>
		
		<div class="input-group">
			<input id="update-value" class="input-group-field" type="number" min="0" step="0.01">
			<div class="input-group-button">
				<input type="submit" class="button" value="Guardar" onclick="saveChanges()">
			</div>
		</div>
		<button class="close-button" data-close aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<!-- <script src="js/vendor/jquery.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<!-- Compressed JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/js/foundation.min.js"></script>
	<script>
		$(document).foundation();
	</script>



	<script>

		function saveChanges(){
			// Recuperamos los valores
			var newValue = $('#modalChengueValue').find('input#update-value').val();
			newValue = parseFloat(newValue).toFixed(2);

			var itemId = $('#modalChengueValue').data('idSave');

			$.ajax({
				method: "POST",
				dataType:'json',
				cache : false,
				url: "http://localhost:8888/codeIgniter/index.php/inventory/updateItemRack",
				data: { 'idItem': itemId, 'newValue': newValue }
			})
			.done(function( msg ) {

				if(msg.code == 200){
					// Si se guardo correctamente actualizamos el valor en la vista
					$('[data-id-item="'+itemId+'"]').children('.rack-item-value').text(newValue)
					$('#modalChengueValue').foundation('close');
				}
				
				
			});
		}

		// Agregamos el evento onClick a todos los elementos del rack
		$(".rack-item").on('click', function(e){
			

			// Recuperamos el id para guardar posteriormente
			var itemId = $(this).data('idItem');

			// Recuperamos el valor actual
			var itemValue = $(this).children('.rack-item-value').text();
			itemValue = parseFloat(itemValue).toFixed(2);

			// Guardamos el id para enviarlo al actualizar la informacion en el modal
			$('#modalChengueValue').data('idSave',itemId);
			// Enviamos el valor actual al modal para prellenarlo
			$('#modalChengueValue').find('input#update-value').val(itemValue);
			// Abrimos el modal
			$('#modalChengueValue').foundation('open');
		});
	</script>



	
	


	

</body>
</html>