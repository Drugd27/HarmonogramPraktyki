<!DOCTYPE HTML> 
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Harmonogram pracy</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="script" href="./skrypt.js">
</head>
<body>
<section>
    <form action="harmonogram.php" method="POST" id="filtry">
        od: <input type="date" name="data_od">
        do: <input type="date" name="data_do">
        <input type="checkbox" id="opis"> Wyświetl opisy prac
        <input type="submit" value="Filtruj" onclick="filtruj()">
    </form>
    
    <br><br>
</section>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tygodniowyharmonogram";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if($conn -> connect_error){
        die("Nie połączono z bazą danych: " . $conn -> connect_error);
    }

    $sql = "SELECT Data, 
                   GROUP_CONCAT(Pracownik SEPARATOR ', ') AS Pracownicy, 
                   GROUP_CONCAT(Firma SEPARATOR ', ') AS Firmy, 
                   Godzina 
            FROM `harmonogram` 
            GROUP BY Data";

    $result = $conn->query($sql);

    echo "<table id='tabela'>";
    if ($result->num_rows > 0) {
        echo "<tr>";
        echo "<th>Data</th>";
        echo "<th>Pracownicy</th>";
        echo "<th>Firmy</th>";
        echo "<th>Godzina</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            // Split Pracownicy and Firmy into arrays
            $pracownicy = explode(', ', $row["Pracownicy"]);
            $firmy = explode(', ', $row["Firmy"]);
            $godziny = explode

            // Ensure both arrays have the same length
            $maxRows = max(count($pracownicy), count($firmy));

            for ($i = 0; $i < $maxRows; $i++) {
                echo "<tr>";
                // Display Data and Godzina only for the first row of each group
                if ($i == 0) {
                    echo "<td rowspan='$maxRows'>" . $row["Data"] . "</td>";
                    echo "<td rowspan='$maxRows'>" . $row["Godzina"] . "</td>";
                }
                echo "<td>" . ($pracownicy[$i] ?? '') . "</td>";
                echo "<td>" . ($firmy[$i] ?? '') . "</td>";
                echo "</tr>";
            }
        }
    } else {
        echo "<tr><td colspan='4'>Brak danych w bazie danych</td></tr>";
    }
    echo "</table>";
?>


</body>
</html>

