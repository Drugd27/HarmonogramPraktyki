<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tygodniowyharmonogram";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Nie połączono z bazą danych: " . $conn->connect_error);
}

// Get the selected Pracownik from the form
$pracownik = isset($_POST['pracownik']) ? $_POST['pracownik'] : null;

if ($pracownik) {
    // Fetch data for the selected Pracownik
    $sql = "SELECT Data, Godzina, Firma, Opis 
            FROM `harmonogram` 
            WHERE Pracownik = '$pracownik' 
            ORDER BY Data, Godzina";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Create a new Word document
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Add a title
        $section->addText("Raport dla pracownika: $pracownik", ['bold' => true, 'size' => 16]);

        // Add a table
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
        $table->addRow();
        $table->addCell(2000)->addText("Data", ['bold' => true]);
        $table->addCell(2000)->addText("Godzina", ['bold' => true]);
        $table->addCell(2000)->addText("Firma", ['bold' => true]);
        $table->addCell(4000)->addText("Opis", ['bold' => true]);

        // Populate the table with data
        while ($row = $result->fetch_assoc()) {
            $table->addRow();
            $table->addCell(2000)->addText($row['Data']);
            $table->addCell(2000)->addText($row['Godzina']);
            $table->addCell(2000)->addText($row['Firma']);
            $table->addCell(4000)->addText($row['Opis']);
        }

        // Save the document
        $filename = "Raport_$pracownik.docx";
        $phpWord->save($filename, 'Word2007');

        // Offer the file for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);

        // Delete the file after download
        unlink($filename);
        exit;
    } else {
        echo "Brak danych dla wybranego pracownika.";
    }
} else {

    $answer = "Nie wybrałeś żadnego pracownika.";
    echo "<script type='text/javascript'>
    
           alert('$answer');

          </script>";

}
?>