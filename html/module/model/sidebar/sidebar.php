<?php
if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
{
    include "group/sidebaradmin.php";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033" or $_SESSION["LOGINDEP_MT"] == "DEPT-0029" or $_SESSION["LOGINDEP_MT"] == "DEPT-0011") //IT & GA
{
	include "group/sidebaritmeka.php";
}
elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") //MEKANIK
{
	include "group/sidebarmeka.php";
}
else
{
	include "group/sidebarlain.php";
}
?>