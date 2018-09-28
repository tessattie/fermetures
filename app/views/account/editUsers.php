<table class="table table-bordered">
		<thead>
			<tr><th colspan="7">Users</th></tr>
			<tr><th>Last name</th><th>First name</th><th>Username</th><th>Email</th><th>Access</th><th>Charge Types</th><th>Actions</th></tr>
			<form method = "POST" action = "/caisses/public/account/index">
				<tr><th><input type="text" class="form-control" name="lastname" placeholder="Last name" required></th>
					<th><input type="text" class="form-control" name="firstname" placeholder="First name" required></th>
					<th><input type="text" class="form-control" name="username" placeholder="Username" required></th>
					<th><input type="email" class="form-control" name="email" placeholder="Email" required></th>
					<th>
						<select class= "form-control" name="role">
							<option value = "20">Admin</option>
							<option value = "21">User</option>
						</select>
					</th>
					<th>
						<select class="mdb-select md-form colorful-select dropdown-primary form-control" name="vendors[]" style="height:80px" multiple searchable="Search here..">
						    <option value="" disabled selected>-- ALL --</option>
						    <option value="1200">Initial Charge</option>
						    <option value="1201">Drwr Cash</option>
						    <option value="1205">Drwr Cash US</option>
						    <option value="1206">Drwr Charge</option>
						    <option value="1294">Drwr Check UB US</option>
						    <option value="1293">Drwr Check UB G</option>
						    <option value="1295">Drwr Credit Card G</option>
						    <option value="1296">Drwr Credit Card US</option>
						    <option value="124">Gift Card</option>
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
					echo "<td>" . $data['users'][$i]['role'] . "</td>";
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