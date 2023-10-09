<?php
include "../Eindopdracht/dbconfig.php";
global $con;
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <div class="header-title-container"><h1 class="header-title">SQL Eindopdracht</h1></div>
    <div class="menu">
        <div class="menu-item"><a class="menu-item-link" href="index.php" title="">SALES</a></div>
        <div class="menu-item"><a class="menu-item-link" href="customers.php" title="">CUSTOMERS</a></div>
        <div class="menu-item"><a class="menu-item-link" href="products.php" title="">PRODUCTS</a></div>
    </div>
</div>
<div class="page">
    <div class="page-title-container"><h1 class="page-title">Customers</h1></div>
    <div class="page-title-background"></div>
    <div class="content-block-1">
        <div class="content-title-container">
            <h1 class="content-title">Search Customers</h1>
            <p class="content-description">Zoek klanten met een beginletter.</p>
        </div>
        <div class="content">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $input = $_POST['text'];
            } else  {
                $input = "v";
            }

            $sqlSearchCustomers = "SELECT customerName AS 'customer', CONCAT(contactFirstName, ' ' , contactLastName) AS 'contact', phone FROM `customers` WHERE customerName LIKE '" . $input . "%';";
            $sqlResult = mysqli_query($con,$sqlSearchCustomers);

            echo "<div class='center-div'>";
            echo "<form method='post' action='customers.php'><span class='content-text'>Alle klanten beginnend met: </span><input class='textarea bold' type='text' name='text' title='Textarea' maxlength='1' size='2' autocomplete='off' value='" . $input . "'></form>";
            echo "<p class='content-text'>Het aantal klanten in deze selectie is: <span class='bold'>" . mysqli_num_rows($sqlResult) ."</span></p><br>";
            echo "</div>";

            if (mysqli_num_rows($sqlResult) > 0){
                echo "<table><thead><tr>";
                for ($x = 0; $x < mysqli_field_count($con); $x++) {
                    $finfo = mysqli_fetch_field_direct($sqlResult, $x);
                    echo "<th>" . $finfo->name . "</th>";
                }
                echo "</tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($sqlResult)){
                    echo "<tr>";
                    for ($x = 0; $x < mysqli_field_count($con); $x++) {
                        $finfo = mysqli_fetch_field_direct($sqlResult, $x);
                        if ($finfo->name == 'status'){
                            $statusInfo = strtolower(str_replace(" ", "-", $row[$finfo->name]));
                            echo "<td><p class='column-" . $finfo->name . " " . $statusInfo ."'>" . $row[$finfo->name] . "</p></td>";
                        } else {
                            echo "<td><p class='column-" . $finfo->name . "'>" . $row[$finfo->name] . "</p></td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='bold2 content-text'>Geen klanten in deze selectie.</p>";
            }
            ?>
        </div>
    </div>
    <div class="content-block-2">
        <div class="content-title-container">
            <h1 class="content-title">Credit Limits</h1>
            <p class="content-description">Klanten in de USA, Australie en Japan met een kredietlimiet van meer dan €100.000.</p>
        </div>
        <div class="content">
            <?php
            $sqlCreditLimits = "SELECT customerName AS 'customer', country, CONCAT('€', creditLimit) AS 'creditLimit' FROM `customers` WHERE country = 'USA' AND creditLimit >= 100000 OR country = 'Australia' AND creditLimit >= 100000 OR country = 'Japan' AND creditLimit >= 100000;";
            $sqlResult = mysqli_query($con,$sqlCreditLimits);
            echo "<table><thead><tr>";
            for ($x = 0; $x < mysqli_field_count($con); $x++) {
                $finfo = mysqli_fetch_field_direct($sqlResult, $x);
                echo "<th>" . $finfo->name . "</th>";
            }
            echo "</tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($sqlResult)){
                echo "<tr>";
                for ($x = 0; $x < mysqli_field_count($con); $x++) {
                    $finfo = mysqli_fetch_field_direct($sqlResult, $x);
                    if ($finfo->name == 'status'){
                        $statusInfo = strtolower(str_replace(" ", "-", $row[$finfo->name]));
                        echo "<td><p class='column-" . $finfo->name . " " . $statusInfo ."'>" . $row[$finfo->name] . "</p></td>";
                    } else {
                        echo "<td><p class='column-" . $finfo->name . "'>" . $row[$finfo->name] . "</p></td>";
                    }
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
            ?>
        </div>
    </div>

    <div class="content-block-3">
        <div class="content-title-container">
            <h1 class="content-title">Country Overviews</h1>
            <p class="content-description">Overzicht van landen met meer dan 10 klanten in dat land.</p>
        </div>
        <div class="content">
            <?php
            $sqlCountryOverviews = "SELECT country, COUNT(*) AS 'aantal' FROM `customers` GROUP BY country HAVING COUNT(*)>=10;";
            $sqlResult = mysqli_query($con,$sqlCountryOverviews);
            echo "<table><thead><tr>";
            for ($x = 0; $x < mysqli_field_count($con); $x++) {
                $finfo = mysqli_fetch_field_direct($sqlResult, $x);
                echo "<th>" . $finfo->name . "</th>";
            }
            echo "</tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($sqlResult)){
                echo "<tr>";
                for ($x = 0; $x < mysqli_field_count($con); $x++) {
                    $finfo = mysqli_fetch_field_direct($sqlResult, $x);
                    if ($finfo->name == 'status'){
                        $statusInfo = strtolower(str_replace(" ", "-", $row[$finfo->name]));
                        echo "<td><p class='column-" . $finfo->name . " " . $statusInfo ."'>" . $row[$finfo->name] . "</p></td>";
                    } else {
                        echo "<td><p class='column-" . $finfo->name . "'>" . $row[$finfo->name] . "</p></td>";
                    }
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
            ?>
        </div>
    </div>
</div>
</body>