<?php
	session_start();
	ini_set("date.timezone","Asia/Jakarta");
	ini_set('max_execution_time', 0); //300 seconds = 5 minutes
	$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');
	$TGL = date("Y-m-d");
	$mysqli = new mysqli("192.168.10.167:3307","maintenance","maintenanceangka8","maintenance");
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) // last request was more than 600sec or 10 minutes ago
	{
		unset($_SESSION["LOGINIDUS_MT"]); // unset $_SESSION variable for the run-time
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

	header("Refresh:602"); // refresh page every 602 sec.

	// generate autonumber
	function kodeAuto($namatabel,$namakolom)
	{
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$akhir = 0;
		$stmt = $db1->query("select max($namakolom) as akhir from $namatabel");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			if(isset($row["akhir"]))
			{
				$akhir = intval($row["akhir"]);
			}
		}
		$akhir = $akhir + 1;
		return $akhir;
	}

	function GetData($kolom,$from){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare("select $kolom from $from") or trigger_error(mysql_error()); 
		$result->execute();
		return $result;
	}

	function GetData1($kolom,$from,$where){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare("select $kolom from $from where $where") or trigger_error(mysql_error()); 
		$result->execute();
		return $result;
	}

	// QUery Mysql
	function GetQuery($query){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare($query) or trigger_error(mysql_error()); 
		$result->execute();

		return $result;
	}

	function GetDataOrder($kolom,$from,$where,$order){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare("select $kolom from $from where $where order by $order") or trigger_error(mysql_error()); 
		$result->execute();
		return $result;
	}

	function GetDataGroup($kolom,$from,$where,$group){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare("select $kolom from $from where $where group by $group") or trigger_error(mysql_error()); 
		$result->execute();
		return $result;
	}

	function UpdateData($from,$kolom,$where){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare("update $from set $kolom where $where") or trigger_error(mysql_error()); 
		$result->execute();
		return $result;
	}

	function InsertData($table,$kolom,$values){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare("insert into $table ($kolom) values ($values)") or trigger_error(mysql_error()); 
		$result->execute();	
		return $result;
	}

	function DeleteData($table,$where){
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');

		$result = $db1->prepare("delete from $table where $where") or trigger_error(mysql_error()); 
		$result->execute();
				return $result;
	}

	function merge_queries(array $original, array $updates) {
    $params = array_merge($original, $updates);
    return '?'.http_build_query($params);
	}

	function createKode($namaTabel,$namaKolom,$awalan,$jumlahAngka)
	{
		$db1 = new PDO('mysql:host=192.168.10.167:3307;dbname=maintenance', 'maintenance', 'maintenanceangka8');
		$angkaAkhir = 0;
		
		$stmt = $db1->query("select max(right($namaKolom,$jumlahAngka)) as akhir from $namaTabel where $namaKolom like '".$awalan."%' ");
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			if(isset($row["akhir"]))
			{
				$angkaAkhir = intval($row["akhir"]);
			}
		}
		$angkaAkhir = $angkaAkhir + 1;
		return $awalan.substr("00000000".$angkaAkhir,-1*$jumlahAngka);
	}
	// function nextAutoincrement($namaTabel)
	// {
	// 	$result = mysql_query("SHOW TABLE STATUS LIKE '$namaTabel'");
	// 	$row = mysql_fetch_array($result);
	// 	$nextId = $row['Auto_increment'];   
	// 	return $nextId;
	// }
	function getIp(){
	    $IP_ADDRESS = $_SERVER['REMOTE_ADDR'];     
	    if($IP_ADDRESS){
	        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	            $IP_ADDRESS = $_SERVER['HTTP_CLIENT_IP'];
	        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	            $IP_ADDRESS = $_SERVER['HTTP_X_FORWARDED_FOR'];
	        }
	        return $IP_ADDRESS;
	    }
	    // There might not be any data
	    return false;
	}

	$result1 = GetQuery("select KODE_PERBAIKAN,DATEDIFF('$TGL',TGL_END) as TGL_END from t_perbaikan where HASIL IS NULL and TGL_END IS NOT NULL");
	while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
		if ($row1["TGL_END"] >= 3) {
			$KODE_PERBAIKAN = $row1["KODE_PERBAIKAN"];
			UpdateData("t_perbaikan","HASIL = 5","KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
		}
	}
?>