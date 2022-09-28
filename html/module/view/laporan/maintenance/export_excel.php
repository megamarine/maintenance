<?php
require_once ("../../../../module/model/koneksi/koneksi.php");

    if ($_SESSION["LOGINAKS_MT"] == "Administrator") 
    {
        include "group_excel/exexcel_admin.php";
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0033") 
    {
        include "group_excel/exexcel_it.php";
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0011") 
    {
        include "group_excel/exexcel_civil.php";
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0040") 
    {
        include "group_excel/exexcel_mekanik.php";
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0094") 
    {
        include "group_excel/exexcel_ga.php";
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0090") 
    {
        include "group_excel/exexcel_qc.php";
    }
    elseif ($_SESSION["LOGINDEP_MT"] == "DEPT-0056") 
    {
        include "group_excel/exexcel_qsd.php";
    }
    else
    {
        include "group_excel/exexcel_lain.php";
    }
?>