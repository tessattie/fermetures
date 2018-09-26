<hr>
		<table class="table table-bordered table-hover table-striped" style = "background:white">
		<thead>
		<tr><th colspan="6" style="text-align:left;vertical-align:middle">[ GLOBAL REPORT ] - [ PERIOD : Daily ] - [ CASHIER : #<?= $data['report'][0]['F1126'] . " - " . $data['report'][0]['F1127'] ?> ] - 
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
			<tbody>
				<tr><th colspan="6" style="color:#5cb85c">TOTAL SALES</th></tr>
				<?php foreach($data['report'] as $r) : ?>
					<?php if($r['F1034'] == 2) : ?>
					<tr>
						<td style="width:5%"><?= $r['F1034'] ?></td>
							<td style="text-align:left;width:55%"><?= $r['F1039'] ?></td>
							<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F65'] == ".00") ? "-" : "$". number_format((float)$r['F65'], 2, ".", ","); ?></td>
							<td style="width:10%;">
								-							
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<tbody>
				<tr><th colspan="6" style="color:#5cb85c">SALES</th></tr>
				<?php foreach($data['report'] as $r) : ?>
					<?php if($r['F1034'] >= 3 && $r['F1034'] <= 10) : ?>
					<tr>
						<td style="width:5%"><?= $r['F1034'] ?></td>
							<td style="text-align:left;width:55%"><?= $r['F1039'] ?></td>
							<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F65'] == ".00") ? "-" : "$". number_format((float)$r['F65'], 2, ".", ","); ?></td>
							<td style="width:10%;">
								-							
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<tbody>
				<tr><th colspan="6" style="color:#5cb85c">TENDERS</th></tr>
				<?php foreach($data['report'] as $r) : ?>
					<?php if($r['F1034'] >= 101 && $r['F1034'] <= 196) : ?>
					<tr>
						<td style="width:5%"><?= $r['F1034'] ?></td>
							<td style="text-align:left;width:55%"><?= $r['F1039'] ?></td>
							<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F65'] == ".00") ? "-" : "$". number_format((float)$r['F65'], 2, ".", ","); ?></td>
							<td style="width:10%;">
								-							
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<tbody>
				<tr><th colspan="6" style="color:#5cb85c">PAID OUT</th></tr>
				<?php foreach($data['report'] as $r) : ?>
					<?php if($r['F1034'] == 239) : ?>
					<tr>
						<td style="width:5%"><?= $r['F1034'] ?></td>
							<td style="text-align:left;width:55%"><?= $r['F1039'] ?></td>
							<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F65'] == ".00") ? "-" : "$". number_format((float)$r['F65'], 2, ".", ","); ?></td>
							<td style="width:10%;">
								-							
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<tbody>
				<tr><th colspan="6" style="color:#5cb85c">IN DRAWER</th></tr>
				<?php foreach($data['report'] as $r) : ?>
					<?php if($r['F1034'] >= 1201 && $r['F1034'] <= 1296) : ?>

					<?php  
					$value = 0;
						if(!empty($data['saved_report'])){
							$value = "";
							for($j=0;$j<count($data['saved_report']);$j++){
								if($data['saved_report'][$j]['sale_id'] == $r['F1034']){
									$value = $data['saved_report'][$j]['real_amount'];
									$condition = true;
								}else{
									if($condition == false){
										$value ="-";
									}
								}
							} 
						}
					?>
					<tr>
						<td style="width:5%"><?= $r['F1034'] ?></td>
							<td style="text-align:left;width:55%"><?= $r['F1039'] ?></td>
							<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F65'] == ".00") ? "-" : "$". number_format((float)$r['F65'], 2, ".", ","); ?></td>
							<td style="width:10%;">
								$<?= number_format($value, 2, ".", ","); ?>						
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<tbody>
				<tr><th colspan="6" style="color:#5cb85c">DECLARED</th></tr>
				<?php foreach($data['report'] as $r) : ?>
					<?php if($r['F1034'] >= 1301 && $r['F1034'] <= 1396) : ?>
					<tr>
						<td style="width:5%"><?= $r['F1034'] ?></td>
							<td style="text-align:left;width:55%"><?= $r['F1039'] ?></td>
							<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F65'] == ".00") ? "-" : "$". number_format((float)$r['F65'], 2, ".", ","); ?></td>
							<td style="width:10%;">
								-							
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<table class="table table-bordered table-hover table-striped" style = "background:white">
			<tbody>
				<tr><th colspan="6" style="color:#5cb85c">INFORMATION</th></tr>
				<?php foreach($data['report'] as $r) : ?>
					<?php if($r['F1034'] >= 3001 && $r['F1034'] <= 3401) : ?>
					<tr>
						<td style="width:5%"><?= $r['F1034'] ?></td>
							<td style="text-align:left;width:55%"><?= $r['F1039'] ?></td>
							<td style="width:10%"><?= ($r['F67'] == ".000") ? "-" : number_format((float)$r['F67'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F64'] == ".0000") ? "-" : number_format((float)$r['F64'], 2, ".", ","); ?></td>
							<td style="width:10%"><?= ($r['F65'] == ".00") ? "-" : "$". number_format((float)$r['F65'], 2, ".", ","); ?></td>
							<td style="width:10%;">
								-							
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>