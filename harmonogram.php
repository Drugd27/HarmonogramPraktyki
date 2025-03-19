<!DOCTYPE HTML> 
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Harmonogram pracy</title>
    <link rel="stylesheet" href="style.css">
    <link rel="script" href="skrypt.js">
<body>
<section>
    od: <input type="date">
    do: <input type="date">

    <input type="checkbox"> Wyświetl opinie
    <br><br>
</section>
<section>
    <table id="tabela">
        <tr>
            <th>Data</th>
        </tr>
        <tr>
            
        </tr>
        <tr>

        </tr>
        <tr>

        </tr>
        <tr>

        </tr>
        <tr>

        </tr>

    </table>
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

    $sql = "SELECT Pracownik, Data,  Godzina, GROUP_CONCAT(DISTINCT Firma, ' ', ID_Uslugi SEPARATOR ', <br>') AS Firma FROM `harmonogram` 
            GROUP BY Pracownik";

    $result = $conn -> query($sql);

    echo "<table id='tabela'>";
    if($result -> num_rows > 0){
        while($row = $result -> fetch_assoc()){
        
            echo "<th>" . $row["Data"] . "</th>";
            
            echo "<tr>";
                echo"<td>" . $row["Pracownik"] . "</td>";
                echo"<td>" . $row["Firma"]. "</td>";
                echo"<td>" .  $row["Godzina"]. "</td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Brak danych w bazie danych</td></tr>";
    }
    echo "</table>";
?>


</body>
</html>

