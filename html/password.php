<?php  
require_once ("module/model/koneksi/koneksi.php");

$DATE = date('Y-m-d H:i:s');

$options = [
    'cost' => 12,
];

$query = GetQuery("select kode_user, pass from temp");
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$kode_user = $row["kode_user"];
	$pass      = $row["pass"];
	$hashed    = password_hash($pass, PASSWORD_BCRYPT, $options);

	$update = GetQuery("update m_user set PASSWORD = '$hashed', MODIFIED_DATE = '$DATE' where kode_user = '$kode_user'");

	if($update)
	{
		echo $kode_user."//".$pass."//".$hashed."<br>";
	}
	else
	{
		echo "Fail to update : ".$kode_user."<br>";
	}
}

?>