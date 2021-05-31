<?php
use yii\helpers\Html;
?>

<?php if (!$errors): ?>
	<?php
	//foreach ($detalle_orden as $detalle) {}

	foreach ($response_envia as $response_envia) {
		foreach ($response_envia as $key => $value) {
			$numero_envio = $value['numero_envio'];
			$codigo_encaminamiento = $value['codigo_encaminamiento'];
		}
	}
	?>

	<div class="container-fluid">
		<h1 class="mt-4">Orden:<?= $orden['id']; ?></h1>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Nro</th>
					<th scope="col">Guía</th>
					<th scope="col">Email destinatario</th>
					<th scope="col">Nombre destinatario</th>
					<th scope="col">Acción</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $orden['id']; ?></td>
					<td><?= $numero_envio; ?></td>
					<td><?= $orden['email_destinatario']; ?></td>
					<td><?= $orden['nombre_destinatario']; ?></td>
					<td><?= Html::a('Imprimir etiqueta',['etiqueta/printer','etiqueta'=>$numero_envio]);?></td>
				</tr>  
			</tbody>
		</table>
		
		Detalle de la orden
		<hr>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Codigo</th>
					<th scope="col">Producto</th>
					<th scope="col">Cantidad</th>
					<th scope="col">Precio</th>
					<th scope="col">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0;$i<count($detalle['line_items']);$i++): ?>
					<?php $item = $detalle['line_items'][$i]; ?>
					<tr>
						<td><?= $item['product_id']; ?></td>
						<td><?= $item['title']; ?></td>
						<td><?= $item['quantity']; ?></td>
						<td><?= $item['price_set']['shop_money']['amount']; ?></td>
						<td><?= (int)$item['quantity'] * (float)$item['price_set']['shop_money']['amount']; ?></td>
					</tr>
				<?php endfor; ?>
				<tr>
					<td colspan="4"><strong>Total</strong></td>
					<td><strong>$ <?= number_format((int)$orden['total_price'],2,',','.') ?></strong></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php else: ?>
	No hay datos. <a href="/index.php?r=ordenes%2Findex"><<< Regresar</a>
<?php endif ?>