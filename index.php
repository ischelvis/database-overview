<?php
include "../Eindopdracht/dbconfig.php";
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
        <div class="page-title-container"><h1 class="page-title">Sales</h1></div>
        <div class="page-title-background"></div>
        <div class="content-block-1">
            <div class="content-title-container">
                <h1 class="content-title">Shipped Orders</h1>
                <p class="content-description">Overzicht van de orders met een orderdatum in 2005, met de status shipped en waarbij het veld comments gevuld is.</p>
            </div>
            <div class="content">
                <?php
                $sqlShippedOrders = "SELECT orderNumber AS 'order', orderDate, status, comments FROM `orders` WHERE orderDate >= '2005-01-01' AND orderDate <= '2005-12-31' AND status = 'Shipped' AND NOT comments='NULL';";
                $sqlResult = mysqli_query($con,$sqlShippedOrders);
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
        <div class="content-block-2">
            <div class="content-title-container">
                <h1 class="content-title">Order Statuses</h1>
                <p class="content-description">Overzicht van het aantal orders per status en per jaar, voor de jaren 2004 en 2005, uit de tabel orders.</p>
            </div>
            <div class="content">
                <?php
                $sqlOrderStatuses = "SELECT YEAR(orderDate) AS 'jaar', status, COUNT(*) AS 'aantal' FROM `orders` WHERE YEAR(orderDate) >= 2004 AND YEAR(orderDate) <= 2005 GROUP BY YEAR(orderDate), status ORDER BY orderDate DESC;";
                $sqlResult = mysqli_query($con,$sqlOrderStatuses);
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
                <h1 class="content-title">Received Payments</h1>
                <p class="content-description">Overzicht van het totaal van alle ontvangen betalingen per jaar, uit de tabel payments.</p>
            </div>
            <div class="content">
                <?php
                $sqlReceivedPayments = "SELECT YEAR(paymentDate) AS 'jaar', COUNT(*) AS 'aantal', CONCAT('€', FORMAT(SUM(amount), 0, 'de_DE')) AS 'totaal' FROM `payments` GROUP BY YEAR(paymentDate) ORDER BY paymentDate DESC;";
                $sqlResult = mysqli_query($con,$sqlReceivedPayments);
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