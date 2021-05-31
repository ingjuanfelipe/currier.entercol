<?php use  yii\helpers\Html;?>
<div class="container-fluid">
	<h1 class="mt-4">Órdenes</h1>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col" style="width:10px">#</th>
				<th scope="col">Fecha</th>
				<th scope="col">Email del Cliente</th>
				<th scope="col">Datos del destinatario</th>
				<th scope="col">Datos del Producto</th>
				<th scope="col">Valor Total con Impuestos</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($model['orders'] as $key => $value): ?>
				<?php $tel = !empty($value['phone'])? $value['phone'] : "000000000"; ?>
				<tr>
					<th scope="row">
						<?= Html::a($value['id'],['ordenes/detalle','id'=>$value['id']],['target'=>'_blank']) ?>
					</th>
					<td><?=$value['created_at']?></td>
					<td><?=$value['customer']['email']?></td>
					<td>
						<div><?=$value['shipping_address']['name']?></div>
						<div><?=$value['shipping_address']['city']?></div>
						<div><?=$value['shipping_address']['address1']?></div>
						<div><?=$value['shipping_address']['phone']?></div>
					</td>
					<td>
						<?php foreach ($value['line_items'] as $k => $producto): ?>
							<div>SKU: <?= $producto['sku'] ?></div>
							<div>Nombre: <?= $producto['title'] ?></div>
							<div>Cantidad: <?= $producto['quantity'] ?></div>
							<div>Precio: <?= $producto['price'] ?></div>
						<?php endforeach ?>
					</td>
					<td><?= $value['total_price'] ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>