<!DOCTYPE HTML> 
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Harmonogram pracy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/png" href="logo.png">
    <style>
        <?php include 'style.css'; ?>
    </style>
    <script>
        <?php include 'skrypt.js'; ?>   
    </script>

</head>
<body class="build">
<link rel="script" href="skrypt.js">
<header>
    <h2>Harmonogram pracy od 17.03.2025 do 24.03.2025</h2>
</header>
<section id='left'>
    <form action="harmonogram.php" method="POST" id="filtry">
        <h3>Wybierz zakres dat:</h3>
        <label>od: </label>
        <input type="date" name="data_od" value="<?php echo isset($_POST['data_od']) ? $_POST['data_od'] : ''; ?>">
        <label>do: </label>
        <input type="date" name="data_do" value="<?php echo isset($_POST['data_do']) ? $_POST['data_do'] : ''; ?>">
        <br><br> &nbsp
        <input type="checkbox" id="opis" name="opis"> <span>Wyświetl opisy prac</span> <br>
        <input type="checkbox" id="auto_refresh" name="auto_refresh" onchange="refresh()"> <span>Automatyczne odświeżanie   </span> <br>
        <input type="submit" value="Filtruj" id="filtr_bttn">

    </form>
    
    <br><br>
    <div>
        <img src="silly-cat.gif" alt="Infinite Silliness!!"/>
        <br><br>
    </div>
    
    <div id="raport" name="raport">
        <h3>Generuj raport dla pracownika:</h3><br>
        <form action="generate_report.php" method="POST">
            <select name="pracownik">
                <option value="Paulina Kucharska">Paulina Kucharska</option>
                <option value="Norbert Gierczak">Norbert Gierczak</option>
                <option value="Daniel Jaskółka">Daniel Jaskółka</option>
                <option value="Paweł Bocian">Paweł Bocian</option>
                <option value="Norbert Ciemniak">Norbert Ciemniak</option>
                <option value="Mikołaj Młynarski">Mikołaj Młynarski</option>
            </select> &nbsp&nbsp&nbsp
            <input type="submit" id="generateReport" value="Generuj raport"><br>
        </form>
    </div>
</section>

<?php
    require_once __DIR__ . '/vendor/autoload.php';

    use PhpOffice\PhpWord\PhpWord;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tygodniowyharmonogram";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Nie połączono z bazą danych: " . $conn->connect_error);
    }

    $data_od = isset($_POST['data_od']) ? $_POST['data_od'] : null;
    $data_do = isset($_POST['data_do']) ? $_POST['data_do'] : null;
    $opis_checked = isset($_POST['opis']); 

    $sql = "SELECT Data, Pracownik, Firma, Opis, Godzina 
            FROM `harmonogram`";

    // Filtrowanie danych
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

        
        if ($opis_checked) {
            echo "<th>Opis</th>";
        } else {
            echo "<th>Firma</th>";
        }
        echo "</tr>";

        $currentDate = null;

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";

            if ($currentDate !== $row["Data"]) {
                $currentDate = $row["Data"];
                $dateRowCount = $conn->query("SELECT COUNT(*) as count FROM `harmonogram` WHERE Data = '$currentDate'")->fetch_assoc()['count'];
                echo "<td id='data' rowspan='$dateRowCount'>" . $row["Data"] . "</td>";
            }

            echo "<td>" . $row["Godzina"] . "</td>";
            echo "<td>" . $row["Pracownik"] . "</td>";

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

