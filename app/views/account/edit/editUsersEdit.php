<?php  
	$roles = array(20 => "Admin", 21 => "User");

	$allowed = explode(",", $data['user']['vendors']); 
?>
<table class="table table-bordered">
	<thead>
		<tr><th colspan="7">Users</th></tr>
		<tr><th>Last name</th><th>First name</th><th>Username</th><th>Email</th><th>Access</th><th>Vendors</th><th>Actions</th></tr>
		<form method = "POST" action = "/caisses/public/account/edit/<?= $data['user']['id'] ?>">
			<tr><th><input type="hidden" name="id" value = <?= $data['user']['id'] ?>><input type="text" class="form-control" name="lastname" placeholder="Last name" required value = <?= $data['user']['lastname'] ?>></th>
				<th><input type="text" class="form-control" name="firstname" placeholder="First name" required value = <?= $data['user']['firstname'] ?>></th>
				<th><input type="text" class="form-control" name="username" placeholder="Username" required value = <?= $data['user']['username'] ?>></th>
				<th><input type="email" class="form-control" name="email" placeholder="Email" required value = <?= $data['user']['email'] ?>></th>
				<th>
					<select class= "form-control" name="role">
						<option value = "20" <?= ($data['user']['role'] == 20) ? "selected" : "" ?>>Admin</option>
						<option value = "21" <?= ($data['user']['role'] == 21) ? "selected" : "" ?>>User</option>
					</select>
				</th>
				<th>
					<select class="mdb-select md-form colorful-select dropdown-primary form-control" name="vendors[]" style="height:80px" multiple searchable="Search here..">
					    <option value="" disabled selected>-- ALL --</option>
					    <option value="1200" <?= (in_array("1200", $allowed)) ? "selected" : "" ?>>Initial Charge</option>
					    <option value="1201" <?= (in_array("1201", $allowed)) ? "selected" : "" ?>>Drwr Cash</option>
					    <option value="1205" <?= (in_array("1205", $allowed)) ? "selected" : "" ?>>Drwr Cash US</option>
					    <option value="1206" <?= (in_array("1206", $allowed)) ? "selected" : "" ?>>Drwr Charge</option>
					    <option value="1294" <?= (in_array("1294", $allowed)) ? "selected" : "" ?>>Drwr Check UB US</option>
					    <option value="1293" <?= (in_array("1293", $allowed)) ? "selected" : "" ?>>Drwr Check UB G</option>
					    <option value="1295" <?= (in_array("1295", $allowed)) ? "selected" : "" ?>>Drwr Credit Card G</option>
					    <option value="1296" <?= (in_array("1296", $allowed)) ? "selected" : "" ?>>Drwr Credit Card US</option>
					    <option value="1217" <?= (in_array("1217", $allowed)) ? "selected" : "" ?>>Gift Certificate</option>
					</select>
				</th>
				<th><input type='submit' class="btn btn-default" value='Submit' name="submit"></th>
			</tr>
		</form>
	</thead>
	<tbody>
		<?php  
			$count = count($data['users']);
			for($i=0;$i<$count;$i++)
			{
				echo "<tr>";
				echo "<td>" . strtoupper($data['users'][$i]['lastname']) . "</td>";
				echo "<td>" . $data['users'][$i]['firstname'] . "</td>";
				echo "<td>" . $data['users'][$i]['username'] . "</td>";
				echo "<td>" . $data['users'][$i]['email'] . "</td>";
				echo "<td>" . $roles[$data['users'][$i]['role']] . "</td>";
				if(!empty($data['users'][$i]['vendors'])){
					echo "<td>" . $data['users'][$i]['vendors'] . "</td>";
				}else{
					echo "<td>ALL</td>";
				}
				echo "<td><a href='/caisses/public/account/delete/" . $data['users'][$i]['id'] . "'><input type='submit' class='btn btn-default' value='Delete'></a>
						  <a href='/caisses/public/account/reset/" . $data['users'][$i]['id'] . "'><input type='submit' class='btn btn-default' value='Reset'></a>
						  <a href='/caisses/public/account/edit/" . $data['users'][$i]['id'] . "'><input type='submit' class='btn btn-default' value='Edit'></a></td></td>";
				echo "</tr>";
			}
		?>
	</tbody>
</table>