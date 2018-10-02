
<?php require 'C:\wamp\www\caisses\app\views\header.php'; ?>

<?php require 'C:\wamp\www\caisses\app\views\menu.php'; ?>

<?php 
	if(!empty($data["reportType"])){
		include 'C:\wamp\www\caisses\app\views\reports/' . $data["reportType"] . '.php';
	}
?>

<div class="row">
	<div class="col-md-12">
		<?php if(empty($_COOKIE['cashier']) || empty($_COOKIE['date'])) : ?>
<p class="bg-info" style="text-align:center;padding:15px;border-radius:4px">Please select the cashier and the date you would like to review in the list above</p>
<?php else : ?>


<?php if(!empty($data['report'])) : ?>
	<table class="table table-bordered table-hover table-striped" style = "background:white">
		<thead>
		<tr><th colspan="6" style="text-align:left;vertical-align:middle">[ DETAILED REPORT ] - [ CASHIER : #<?= $data['report'][0]['F1126'] . " - " . $data['report'][0]['F1127'] ?> ] - 
		[ SALES DATE : <?= date("F d Y" , strtotime($_COOKIE['date'])) ?> ] - [ TODAY - <?= date("F d Y") ?> ]</th></tr>
			<tr>
			<th style="width:5%"></th>
				<th style="width:55%">SALE TYPE</th>
				<th style="width:10%">WEIGHT</th>
				<th style="width:10%">QUANTITY</th>
				<th style="width:10%">AMOUNT</th>
				<th  style="width:10%">REAL AMOUNT</th>
			</tr>
		</thead>
		</table>
		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<form method="post" action="/caisses/public/home/saveReport">
			<?php if(!empty($data['saved_report'])) : ?>
				<input type="hidden" value="<?= $data['saved_report'][0]['report_id']  ?>" name="report_id">
			<?php endif; ?>
			<input type="hidden" value="<?= $data['report'][0]['F1126']  ?>" name="cashier_id">
			<input type="hidden" value="<?= $data['report'][0]['F1127']  ?>" name="cashier_name">
				<tbody>
					<tr><th colspan="4" style="color:#5cb85c">IN DRAWER  </th> <th><select class="form-control" name="report_type" required style="font-size:13px;height:31px;margin-top:0px"><option value="">-- Period --</option><option value="2" <?= (!empty($data['saved_report']) && $data['saved_report'][0]['report_type'] == 2) ? "selected" : "" ?>>Midi</option><option value="1" <?= (!empty($data['saved_report']) && $data['saved_report'][0]['report_type'] == 1) ? "selected" : "" ?>>Soir</option> </select></th> <th><input type="submit" style="font-size:12px;width:100%" value="SAVE" name='submit' class="btn btn-success"></th></tr>
					<tr><td>1200</td><td class="text-left">Initial Cash Input</td><td>-</td><td>-</td>
					<td>
					<?php $cashinput = 5000; ?>
						<?php if(!empty($data['saved_report'])) : ?>
							<?php $cashinput = $data['saved_report'][0]['initial_charge']; ?>
							<?= number_format($data['saved_report'][0]['initial_charge'], 2, ".", ",")  ?>
						<?php else : ?>
							<input type="text" value="<?= $cashinput ?>" name="initial_charge" class="form-control" style = "width:100%;text-align:center">
						<?php endif; ?>
					</td>
					<td>-</td></tr>
					<?php $count=0; $real_total = 0; $total=$cashinput;$condition=false; foreach($data['report'] as $r) : ?>
					<?php 	$count = $count+ 1 ?>
						<?php if($r['F1034'] >= 1201 && $r['F1034'] <= 1296) : ?>
						<?php  
						$value = 0;
						$item_id = null;
						$real_total = 0;
							if(!empty($data['saved_report'])){
								$value = 0;
								for($k=0;$k<count($data['saved_report']);$k++){
										$real_total = $real_total + $data['saved_report'][$k]['real_amount'];
								}
								
								for($j=0;$j<count($data['saved_report']);$j++){
									if($data['saved_report'][$j]['sale_id'] == $r['F1034']){
										$value = $data['saved_report'][$j]['real_amount'];
										$item_id = $data['saved_report'][$j]['id'];
										$condition = true;
									}else{
										if($condition == false){
											$value ="";
										}
									}
								} 
							}
						?>
					<?php if($_SESSION['caisses']['role'] == "20") : ?>
						<tr>
							<td style="width:5%"><?= $r['F1034'] ?> <input type="hidden" value="<?= $r['F1034'] ?>" name="sale_id[]"></td>
								<td style="text-align:left;width:55%"><?= $r['F1039'] ?>
								<input type="hidden" value="<?= $r['F1039'] ?>" name="sale_name[]"></td>
								<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F67'] ?>" name="weight[]"> </td>
								<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F64'] ?>" name="quantity[]"> </td>

								<?php if($r['F1034'] == '1201') : ?>
									<td style="width:10%">$<?= ($r['F65'] == ".00") ? "-" : number_format((float)$r['F65'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F65'] + $cashinput ?>" name="amount[]"> 
								<span class = "glyphicon glyphicon-arrow-right copyToInput" style="padding:5px;color:white;background:#f0ad4e;border-radius:3px;float:right;cursor:pointer"></span></td>
								<?php else : ?>
								<td style="width:10%">$<?= ($r['F65'] == ".00") ? "-" : number_format((float)$r['F65'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F65'] ?>" name="amount[]"> 
								<span class = "glyphicon glyphicon-arrow-right copyToInput" style="padding:5px;color:white;background:#f0ad4e;border-radius:3px;float:right;cursor:pointer"></span></td>
								<?php endif; ?>
								<td style="width:10%;" class = "inputLocation">
								<?php if($value == ''){
										$value = 0;
									} 
								?>
								<?php if($value) : ?>
									<input type="text" class= "form-control isNumeric" placeholder = "0" style="width:100%;margin:auto;text-align:center;font-size:12px" name="real_amount[]" value = "<?= number_format($value,2,".","") ?>" >							
								<?php else : ?>
									<input type="text" class= "form-control isNumeric" placeholder = "Enter value" style="width:100%;margin:auto;text-align:center;font-size:12px" name="real_amount[]" >							
								<?php endif; ?>
									<?php if($item_id == null){
										$item_id = '';
										} ?>
										<input type="hidden" value="<?= $item_id ?>" name="item_id[]">
								</td>
							</tr>
							<?php $total = $total + (float)$r['F65'] ?>
					<?php else : ?>
						<?php if( in_array($r['F1034'], $_SESSION['caisses']['vendors'])) : ?>
							<tr>
							<td style="width:5%"><?= $r['F1034'] ?> <input type="hidden" value="<?= $r['F1034'] ?>" name="sale_id[]"></td>
								<td style="text-align:left;width:55%"><?= $r['F1039'] ?>
								<input type="hidden" value="<?= $r['F1039'] ?>" name="sale_name[]"></td>
								<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F67'] ?>" name="weight[]"> </td>
								<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F64'] ?>" name="quantity[]"> </td>

								<?php if($r['F1034'] == '1201') : ?>
									<td style="width:10%">$<?= ($r['F65'] == ".00") ? "-" : number_format((float)$r['F65'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F65'] + $cashinput ?>" name="amount[]"> 
								<span class = "glyphicon glyphicon-arrow-right copyToInput" style="padding:5px;color:white;background:#f0ad4e;border-radius:3px;float:right;cursor:pointer"></span></td>
								<?php else : ?>
								<td style="width:10%">$<?= ($r['F65'] == ".00") ? "-" : number_format((float)$r['F65'], 2, ".", ","); ?> 
								<input type="hidden" value="<?= $r['F65'] ?>" name="amount[]"> 
								<span class = "glyphicon glyphicon-arrow-right copyToInput" style="padding:5px;color:white;background:#f0ad4e;border-radius:3px;float:right;cursor:pointer"></span></td>
								<?php endif; ?>
								<td style="width:10%;" class = "inputLocation">
								<?php if($value) : ?>
									<input type="text" class= "form-control isNumeric" placeholder = "0" style="width:100%;margin:auto;text-align:center;font-size:12px" name="real_amount[]" value = "<?= number_format($value,2,".","") ?>" >							
								<?php else : ?>
									<input type="text" class= "form-control isNumeric" placeholder = "0" style="width:100%;margin:auto;text-align:center;font-size:12px" name="real_amount[]" >							
								<?php endif; ?>
									<input type="hidden" value="<?= $item_id ?>" name="item_id[]">
								</td>
							</tr>
							<?php $total = $total + (float)$r['F65'] ?>
						<?php endif; ?>
					<?php endif; ?>
						
							
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if($count == 1 && $data['report'][0]['F1034'] == 3199) : ?>
						<tr><th colspan="6" style="text-align:center;font-style:italic">this user logged in but did not make any transactions. No edits are needed.</th></tr>
					<?php 	endif; ?>
					<tr><th colspan="4" style="text-align:right">TOTAL</th> <th class="text-center"><label class="label label-primary" style="font-size:14px;padding: .4em .6em .3em;">$<?= number_format($total,2,".",",") ?></label></th>
					<th class="text-center"><label class="label label-info" style="font-size:14px;padding: .4em .6em .3em;">$<?= number_format($real_total,2,".",",") ?></label></th></tr>
				</form>
			</tbody>
		</table>

		
		

	<style type="text/css">
	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
		vertical-align: middle!important;
	}
	</style>
<?php else : ?>

	<p class="bg-danger" style="text-align:center;padding:15px;border-radius:4px">Nothing found for the cashier and date you selected.</p>

<?php endif; ?>

<?php endif; ?>
	</div>
	
</div>	


<?php require 'C:\wamp\www\caisses\app\views\footer.php'; ?>

