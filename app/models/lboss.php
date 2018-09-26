<?php

class lboss{


	private $db ;


	public function __construct()
	{
		$server_name = 'HOST-STORE\MSSQLSERVER2017';
		$this->db = new PDO( "sqlsrv:server=".$server_name." ; Database = lboss", "sa", "BRd@t@123",
	    array(
	        PDO::ATTR_TIMEOUT => 100000,
	        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	    ));
	}

	public function setReport($report)
	{
		$insert = $this->db->prepare("INSERT INTO reports (cashier_id, cashier_name, timestamp, period, report_type, initial_charge)
	    VALUES (:cashier_id, :cashier_name, :timestamp, :period, :report_type, :initial_charge)");

	    $insert->bindParam(':cashier_id', $report['cashier_id']);
	    $insert->bindParam(':cashier_name', $report['cashier_name']);
	    $insert->bindParam(':timestamp', $report['timestamp']);
	    $insert->bindParam(':period', $report['period']);
	    $insert->bindParam(':report_type', $report['report_type']);
	    $insert->bindParam(':initial_charge', $report['initial_charge']);

	    $insert->execute();
	    return $this->db->lastInsertId();
	}

	public function getReport($cashier, $date)
	{
		$SQL = "SELECT r.*, i.* FROM dbo.items i 
				LEFT JOIN dbo.reports r on r.id = i.report_id 
				WHERE r.cashier_id = ".$cashier." AND timestamp ='".$date."'";
		$result = $this->db->query($SQL);
		return $result->fetchall(PDO::FETCH_BOTH);
	}

	public function getReports($date, $report_type)
	{
		$SQL = "SELECT r.*, i.* FROM dbo.items i 
				LEFT JOIN dbo.reports r on r.id = i.report_id 
				WHERE timestamp ='".$date."' AND report_type = ".$report_type." 
				ORDER BY r.cashier_id, i.sale_id";
		$result = $this->db->query($SQL);
		return $result->fetchall(PDO::FETCH_BOTH);
	}

	public function getItem($id)
	{
		$SQL = "SELECT * FROM dbo.items i 
				WHERE i.id = ".$id;
		$result = $this->db->query($SQL);
		return $result->fetch(PDO::FETCH_BOTH);
	}

	public function updateItem($id, $real_amount)
	{
		$update = "UPDATE items SET real_amount =" . $real_amount . " WHERE id =" . $id;
		$this->db->query($update);	
	}

	public function setItem($item){
		$insert = $this->db->prepare("INSERT INTO items (sale_id, report_id, weight, quantity, amount, real_amount, sale_name)
	    VALUES (:sale_id, :report_id, :weight, :quantity, :amount, :real_amount, :sale_name)");

	    $insert->bindParam(':sale_id', $item['sale_id']);
	    $insert->bindParam(':report_id', $item['report_id']);
	    $insert->bindParam(':weight', $item['weight']);
	    $insert->bindParam(':quantity', $item['quantity']);
	    $insert->bindParam(':amount', $item['amount']);
	    $insert->bindParam(':real_amount', $item['real_amount']);
	    $insert->bindParam(':sale_name', $item['sale_name']);

	    $insert->execute();
	}

	public function createReports(){
		$SQL = $this->db->prepare("CREATE TABLE reports (
			    id int IDENTITY(1,1) PRIMARY KEY,
			    timestamp datetime NOT NULL,
			    period varchar(255) NOT NULL,
			    cashier_id varchar(255) NOT NULL,
			    cashier_name varchar(255) NOT NULL,
			);");

		$SQL->execute();
	}


	public function createItems(){
		$SQL = $this->db->prepare("CREATE TABLE items (
			    id int IDENTITY(1,1) PRIMARY KEY,
			    report_id int NOT NULL,
			    sale_id varchar(255) NOT NULL,
			    weight float NOT NULL,
			    amount float NOT NULL,
			    quantity float NOT NULL,
			    real_amount float NOT NULL,
			    FOREIGN KEY(report_id) REFERENCES reports(id)
			); 
		");

		$SQL->execute();
	}
}