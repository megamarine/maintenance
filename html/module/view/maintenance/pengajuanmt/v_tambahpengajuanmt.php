<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
{
    include "tambahgroup/tambahgroup_administrator.php";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040" or //MEKANIK
		$_SESSION["LOGINDEP_MT"] == "DEPT-0033" or //IT
		$_SESSION["LOGINDEP_MT"] == "DEPT-0029" or //GA & FINANCE DIRECTOR
		$_SESSION["LOGINDEP_MT"] == "DEPT-0056" or //QSD 1
		$_SESSION["LOGINDEP_MT"] == "DEPT-0011")   //CIVIL ENGINEERING
{
    include "tambahgroup/tambahgroup_itdll.php";
}
else
{
    include "tambahgroup/tambahgroup_lain.php";
}
?>