
<?php require 'C:\wamp\www\caisses\app\views\header.php'; ?>

<?php require 'C:\wamp\www\caisses\app\views\menu.php'; ?>

<?php 
	if(!empty($data["reportType"])){
		include 'C:\wamp\www\caisses\app\views\reports/' . $data["reportType"] . '.php';
	}

	$csh = 'no';

	$total_cash = 0;$total_cash_real = 0;
	$total_initial = 0;$total_initial_real = 0;
	$total_charge = 0;$total_charge_real = 0;
	$total_checku = 0;$total_checku_real = 0;
	$total_checkg = 0;$total_checkg_real = 0;
	$total_ccg = 0;$total_ccg_real = 0;
	$total_ccu = 0;$total_ccu_real = 0;
	$total_cash_us = 0;$total_cash_us_real = 0;

	foreach($data['reports'] as $r){

		if($csh != $r['cashier_id']){
			// $total_cash = $total_cash + $r['initial_charge'];
		}

		if($r['sale_id'] == '1201'){
			$total_cash = $total_cash + $r['amount'];
			$total_cash_real = $total_cash_real + $r['real_amount'];
		}

		if($r['sale_id'] == '1205'){
			$total_cash_us = $total_cash_us + $r['amount'];
			$total_cash_us_real = $total_cash_us_real + $r['real_amount'];
		}

		if($r['sale_id'] == '1206'){
			$total_charge = $total_charge + $r['amount'];
			$total_charge_real = $total_charge_real + $r['real_amount'];
		}

		if($r['sale_id'] == '1293'){
			$total_checkg = $total_checkg + $r['amount'];
			$total_checkg_real = $total_checkg_real + $r['real_amount'];
		}

		if($r['sale_id'] == '1294'){
			$total_checku = $total_checku + $r['amount'];
			$total_checku_real = $total_checku_real + $r['real_amount'];
		}

		if($r['sale_id'] == '1295'){
			$total_ccg = $total_ccg + $r['amount'];
			$total_ccg_real = $total_ccg_real + $r['real_amount'];
		}

		if($r['sale_id'] == '1296'){
			$total_ccu = $total_ccu + $r['amount'];
			$total_ccu_real = $total_ccu_real + $r['real_amount'];
		}

		$csh = $r['cashier_id'];
	}

?>

<div class="row">	
	<div class="col-md-12">
		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<thead>
			<tr><th colspan="6" style="text-align:left;vertical-align:middle">[ TOTALS SUMMARY ] - 
			[ SALES DATE : <?= date("F d Y" , strtotime($_COOKIE['date'])) ?> ] - [ TODAY - <?= date("F d Y") ?> ]</th></tr>
				<tr>
				<th style="width:5%"></th>
					<th style="width:50%">SALE TYPE</th>
					<th style="width:10%">AMOUNT</th>
					<th  style="width:10%">REAL AMOUNT</th>
					<th  style="width:10%">BALANCE</th>

					<th style="width:5%"></th>
				</tr>
			</thead>
			<tbody>	
			<tr>
				<td>1201</td>
				<td class="text-left">Drwr Cash</td>
				<td><?= number_format($total_cash, 2, ".", ",") ?></td>
				<td><?= number_format($total_cash_real, 2, ".", ",") ?></td>
				<td><?= number_format($total_cash - $total_cash_real, 2, ".", ",") ?></td>
				<td></td>
			</tr>
			<tr>
				<td>1205</td>
				<td class="text-left">Drwr US$</td>
				<td><?= number_format($total_cash_us, 2, ".", ",") ?></td>
				<td><?= number_format($total_cash_us_real, 2, ".", ",") ?></td>
				<td><?= number_format($total_cash_us - $total_cash_us_real, 2, ".", ",") ?></td>
				<td></td>
			</tr>
			<tr>
				<td>1206</td>
				<td class="text-left">Drwr Charge</td>
				<td><?= number_format($total_charge, 2, ".", ",") ?></td>
				<td><?= number_format($total_charge_real, 2, ".", ",") ?></td>
				<td><?= number_format($total_charge - $total_charge_real, 2, ".", ",") ?></td>
				<td></td>
			</tr>
			<tr>
				<td>1293</td>
				<td class="text-left">Drwr Check UB G</td>
				<td><?= number_format($total_checkg, 2, ".", ",") ?></td>
				<td><?= number_format($total_checkg_real, 2, ".", ",") ?></td>
				<td><?= number_format($total_checkg - $total_checkg_real, 2, ".", ",") ?></td>
				<td></td>
			</tr>
			<tr>
				<td>1294</td>
				<td class="text-left">Drwr Check UB US</td>
				<td><?= number_format($total_checku, 2, ".", ",") ?></td>
				<td><?= number_format($total_checku_real, 2, ".", ",") ?></td>
				<td><?= number_format($total_checku - $total_checku_real, 2, ".", ",") ?></td>
				<td></td>
			</tr>
			<tr>
				<td>1295</td>
				<td class="text-left">Drwr Credit Card G</td>
				<td><?= number_format($total_ccg, 2, ".", ",") ?></td>
				<td><?= number_format($total_ccg_real, 2, ".", ",") ?></td>
				<td><?= number_format($total_ccg - $total_ccg_real, 2, ".", ",") ?></td>
				<td></td>
			</tr>
			<tr>
				<td>1296</td>
				<td class="text-left">Drwr Credit Card US</td>
				<td><?= number_format($total_ccu, 2, ".", ",") ?></td>
				<td><?= number_format($total_ccu_real, 2, ".", ",") ?></td>
				<td><?= number_format($total_ccu - $total_ccu_real, 2, ".", ",") ?></td>
				<td></td>
			</tr>
			</tbody>

			<tfoot>	
				
			</tfoot>
		</table>
	</div>
</div>	

<?php require 'C:\wamp\www\caisses\app\views\footer.php'; ?>
