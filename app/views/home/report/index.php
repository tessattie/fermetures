
<?php require 'C:\wamp\www\caisses\app\views\header.php'; ?>

<?php require 'C:\wamp\www\caisses\app\views\menu.php'; ?>

<?php 
	if(!empty($data["reportType"])){
		include 'C:\wamp\www\caisses\app\views\reports/' . $data["reportType"] . '.php';
	}

?>

<div class="row">	
	<div class="col-md-12">
		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<thead>
			<tr><th colspan="8" style="text-align:left;vertical-align:middle">[ PERIOD : Daily ] - 
			[ SALES DATE : <?= date("F d Y" , strtotime($_COOKIE['date'])) ?> ] - [ TODAY - <?= date("F d Y") ?> ]</th></tr>
				<tr>
				<th style="width:5%"></th>
					<th style="width:55%">SALE TYPE</th>
					<th style="width:10%">WEIGHT</th>
					<th style="width:10%">QUANTITY</th>
					<th style="width:10%">AMOUNT</th>
					<th  style="width:10%">REAL AMOUNT</th>
					<th colspan="2"  style="width:10%">BALANCE</th>

				</tr>
			</thead>
			<tbody>	
				<?php $dailytotal=0; $dailyrealtotal=0; $p=0; $csh = 'no';$real_total=0;$total=0; foreach($data['reports'] as $rp) : ?>	
					<?php if($csh != $rp['cashier_id']) : ?>
						<?php if($total > 0) : ?>
							<?php $dailytotal = $dailytotal + $total; ?>
							<?php $dailyrealtotal = $dailyrealtotal + $real_total; ?>
						<tr><th colspan="4" style="text-align:right">SUBTOTAL</th><th class="text-center"><label class="label label-primary" style="font-size:12px">$<?= number_format($total, 2, ".", ",") ?></label></th>
						
						<th  class="text-center"><label class="label label-info" style="font-size:12px">$<?= number_format($real_total, 2, ".", ",") ?></label></th>
						<th  class="text-center"><label class="label label-info" style="font-size:12px">$<?= number_format(($real_total-$total), 2, ".", ",") ?></label></th><th></th></tr>
					<?php endif; ?>
						<?php $real_total=0;$total=0; ?>
						<tr><th colspan="8">#<?= $rp['cashier_id'] . " - " . $rp['cashier_name'] ?></th></tr>
						<?php $total = $total ?>
					<?php endif; ?>
					<tr>
						<td><?= $rp['sale_id'] ?></td>
						<td style="text-align:left"><?= $rp['sale_name'] ?></td>
						<td><?= $rp['weight'] ?></td>
						<td><?= $rp['quantity'] ?></td>
						<?php if($rp['sale_id'] == '1201') : ?>
							<td> $<?= number_format($rp['amount'], 2, ".", ",") ?></td>
						<?php else: ?>
							<td> $<?= number_format($rp['amount'], 2, ".", ",") ?></td>
						<?php endif; ?>
						
						<td>$<?= number_format($rp['real_amount'], 2, ".", ",") ?></td>
						<?php if($rp['sale_id'] == '1201') : ?>
							<td> $<?= number_format(($rp['real_amount'] - $rp['amount']), 2, ".", ",") ?></td>
						<?php else: ?>
							<td> $<?= number_format(($rp['real_amount'] - $rp['amount']), 2, ".", ",") ?></td>
						<?php endif; ?>
						<td><a href="/caisses/public/home/deleteItem/<?= $rp['id'] ?>"><span class="glyphicon glyphicon-trash" style="color:red;cursor:pointer;font-size:14px" 
						onclick="return confirm('Are you sure you would like to delete [ <?= trim($rp['sale_name']) ?> ] for the cashier [ #<?= $rp['cashier_id'] . " - " . trim($rp['cashier_name'])?> ] ?')"></span></a></td>
					</tr>
					
					
					<?php 
						$real_total=$real_total+$rp['real_amount'];
						$total=$total + $rp['amount'];
					?>
					<?php $csh = $rp['cashier_id']; $p = $p + 1; ?>

					
				<?php endforeach; ?>
				<?php $dailytotal = $dailytotal + $total; ?>
							<?php $dailyrealtotal = $dailyrealtotal + $real_total; ?>
				<tr><th colspan="4" style="text-align:right">SUBTOTAL</th>
				<th class="text-center"><label class="label label-primary" style="font-size:12px">$<?= number_format($total, 2, ".", ",") ?></label></th>
				<th  class="text-center"><label class="label label-info" style="font-size:12px">$<?= number_format($real_total, 2, ".", ",") ?></label></th>
				<th  class="text-center"><label class="label label-info" style="font-size:12px">$<?= number_format($real_total-$total, 2, ".", ",") ?></label></th><th></th></tr>
			</tbody>

			<tfoot>	
				<tr><th colspan="4" style="text-align:right;background-color:#6e0000;color:white">TOTAL</th>
				<th class="text-center" style="background-color:#6e0000;color:white">$<?= number_format($dailytotal, 2, ".", ",") ?></th>
				<th style="background-color:#6e0000;color:white" class="text-center">$<?= number_format($dailyrealtotal, 2, ".", ",") ?></th>
				<th style="background-color:#6e0000;color:white" class="text-center">$<?= number_format($dailyrealtotal-$dailytotal, 2, ".", ",") ?></th><th style="background-color:#6e0000;color:white" ></th></tr>
			</tfoot>
		</table>
	</div>
</div>	

<?php require 'C:\wamp\www\caisses\app\views\footer.php'; ?>
