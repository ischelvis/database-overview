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
    <div class="page-title-container"><h1 class="page-title">Products</h1></div>
    <div class="page-title-background"></div>
    <div class="content-block-1">
        <div class="content-title-container">
            <h1 class="content-title">Product Stock</h1>
            <p class="content-description">Overzicht van aantallen en totale voorraadwaarde per productLine.</p>
        </div>
        <div class="content">
            <?php
            $sqlStock = "SELECT productLine, COUNT(*) AS 'aantal', CONCAT('€', FORMAT(SUM(quantityInStock)*SUM(buyPrice), 0, 'de_DE')) AS 'waardevoorraad' FROM `products` GROUP BY productLine;";
            $sqlResult = mysqli_query($con,$sqlStock);
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
    <div class="content-block-2-full">
        <div class="content-title-container">
            <h1 class="content-title">Filter Products</h1>
            <p class="content-description">Filter producten op basis van de productlijn.</p>
        </div>
        <div class="content">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $input = $_POST['dropdown'];
            } else  {
                $input = "Classic Cars";
            }

            echo "<div class='center-div'>";
            echo "<form method='post' action='products.php'><span class='content-text'>De geselecteerde productlijn is: </span>";
            echo "<select name='dropdown' onchange='this.form.submit()'>";

            $sqlProductLines = "SELECT productLine FROM `productlines`;";
            $sqlResult = mysqli_query($con,$sqlProductLines);

            echo "<option value='' disabled selected hidden>". $input ."</option>";
            while ($row = mysqli_fetch_assoc($sqlResult)){
                $finfo = mysqli_fetch_field_direct($sqlResult, 0);
                echo "<option value='" . $row[$finfo->name] . "'>" . $row[$finfo->name] . "</option>";
            }

            echo "</select></form>";

            $sqlFilterProducts = "SELECT productCode, productName, buyPrice AS 'price' FROM `products` WHERE productLine = '" . $input . "';";
            $sqlResult = mysqli_query($con,$sqlFilterProducts);

            echo "<p class='content-text'>Het aantal producten in deze productlijn is: <span class='bold'>" . mysqli_num_rows($sqlResult) ."</span></p><br>";
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
                echo "<p class='bold2 content-text'>Geen producten in deze selectie.</p>";
            }
            ?>
        </div>
    </div>
</div>
</body>