<!DOCTYPE HTML> 
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Harmonogram pracy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="script" href="skrypt.js">
    <link rel="icon" type="image/png" href="logo.png">
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>
<body class="build">
<header>
    <h2>Harmonogram pracy od 17.03.2025 do 24.03.2025</h2>
</header>
<section id='left'>
    <form action="harmonogram.php" method="POST" id="filtry">
        <h3>Wybierz zakres dat:</h3>
        od: <input type="date" name="data_od">
        do: <input type="date" name="data_do">
        <br><br> &nbsp
        <input type="checkbox" id="opis" name="opis"> Wyświetl opisy prac
        <input type="submit" value="Filtruj" id="filtr_bttn">
    </form>
    
    <br><br>
    <div>
        <img src="silly-cat.gif" alt="Infinite Silliness!!"/>
    </div>
</section>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tygodniowyharmonogram";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Nie połączono z bazą danych: " . $conn->connect_error);
    }

    // Get the selected dates and checkbox value from the form
    $data_od = isset($_POST['data_od']) ? $_POST['data_od'] : null;
    $data_do = isset($_POST['data_do']) ? $_POST['data_do'] : null;
    $opis_checked = isset($_POST['opis']); // True if checkbox is checked

    // Build the SQL query
    $sql = "SELECT Data, Pracownik, Firma, Opis, Godzina 
            FROM `harmonogram`";

    // Add date filtering
    if ($data_od && $data_do) {
        $sql .= " WHERE Data BETWEEN '$data_od' AND '$data_do'";
    } elseif ($data_od) {
        $sql .= " WHERE Data >= '$data_od'";
    } elseif ($data_do) {
        $sql .= " WHERE Data <= '$data_do'";
    }

    $sql .= " ORDER BY Data, Godzina";

    $result = $conn->query($sql);

    echo "<section id='right'>";
    echo "<table id='tabela'>";
    if ($result->num_rows > 0) {
        echo "<tr>";
        echo "<th id='data'>Data</th>";
        echo "<th>Godzina</th>";
        echo "<th>Pracownik</th>";

        // Adjust table headers based on checkbox
        if ($opis_checked) {
            echo "<th>Opis</th>";
        } else {
            echo "<th>Firma</th>";
        }
        echo "</tr>";

        $currentDate = null;

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";

            // Display the date only for the first row of each group
            if ($currentDate !== $row["Data"]) {
                $currentDate = $row["Data"];
                // Count the number of rows for the current date
                $dateRowCount = $conn->query("SELECT COUNT(*) as count FROM `harmonogram` WHERE Data = '$currentDate'")->fetch_assoc()['count'];
                echo "<td id='data' rowspan='$dateRowCount'>" . $row["Data"] . "</td>";
            }

            echo "<td>" . $row["Godzina"] . "</td>";
            echo "<td>" . $row["Pracownik"] . "</td>";

            // Adjust table content based on checkbox
            if ($opis_checked) {
                echo "<td>" . $row["Opis"] . "</td>";
            } else {
                echo "<td>" . $row["Firma"] . "</td>";
            }

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Brak danych w bazie danych</td></tr>";
    }
    echo "</table>";
    echo "</section>";
?>


</body>
</html>

