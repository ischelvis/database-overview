<?php
mysqli_report(MYSQLI_REPORT_OFF);

$conf["Username"]= 'root';
$conf["Password"]= '';
$conf["Host"]= 'localhost';
$conf["Database"]= 'classicmodels';

$con = @mysqli_connect($conf["Host"], $conf["Username"], $conf["Password"], $conf["Database"]);

if(!$con)
{
    echo ("<p style='font-weight: bold;'>OOPS </p>" . mysqli_connect_error());
}

