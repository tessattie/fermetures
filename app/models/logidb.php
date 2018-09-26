<?php

class logidb{


	private $db ;


	public function __construct()
	{
		$server_name = 'MFS1\LOGI2008';
		$this->db = new PDO( "sqlsrv:server=".$server_name." ; Database = LogiDB", "readOnlyUser", "Apple123");
	}

	public function getCashiers()
	{
		$SQL = "SELECT F1126 AS ident, F1143 AS firstname, F1144 AS lastname, F1127 AS username FROM dbo.CLK_TAB WHERE F1142=2 ORDER BY F1127 ASC";
		$result = $this->db->query($SQL);
		return $result->fetchall(PDO::FETCH_BOTH);
	}

	public function getSaleTypes()
	{
		$SQL = "SELECT F1034 AS ident, F1039 AS sale_type FROM dbo.TLZ_TAB WHERE F1034=101 ORDER BY F1127 ASC";
		$result = $this->db->query($SQL);
		return $result->fetchall(PDO::FETCH_BOTH);
	}

	public function getReport($from, $to, $period, $register)
	{
		$SQL = "SELECT
			RPT.F1185,RPT.F1034,SUM(RPT.F64) AS F64,
			SUM(RPT.F65) AS F65,SUM(RPT.F67) AS F67,TLZ.F2168,TLZ.F2169,
			TLZ.F1039,TLZ.F2120,TLZ.F2170,CLK.F1126,CLK.F1127
		FROM
			RPT_CLK RPT 
			LEFT OUTER JOIN TLZ_TAB TLZ ON (RPT.F1034=TLZ.F1034)
			LEFT OUTER JOIN CLK_TAB CLK ON (CLK.F1185=RPT.F1185)
		WHERE
			RPT.F254='".$from."' AND
			RPT.F1031='".$period."' AND
			CLK.F1126 = ".$register." AND
			(RPT.F1034<8620 OR RPT.F1034>8629)
		GROUP BY
			RPT.F1185,RPT.F1034,TLZ.F1039,TLZ.F2120,
			TLZ.F2168,TLZ.F2169,TLZ.F2170,CLK.F1126,CLK.F1127
		ORDER BY F1034 ASC; 
		";
		$result = $this->db->query($SQL);
		return $result->fetchall(PDO::FETCH_BOTH);
	}
}