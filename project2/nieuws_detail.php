<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwsbericht</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link naar je stylesheet -->
</head>
<body>
    <?php include 'header.php'; ?>

    <div class=".container-nieuws-detail">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = ""; 
        $dbname = "donatie_database";
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        function translateDate($englishDate) {
            $englishMonths = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $dutchMonths = array("Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December");
            $englishDays = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            $dutchDays = array("Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag", "Zondag");
            
            $englishDate = str_replace($englishMonths, $dutchMonths, $englishDate);
            $englishDate = str_replace($englishDays, $dutchDays, $englishDate);
            
            return $englishDate;
        }

        // Controleer of de 'id' parameter in de URL is ingesteld
        if (isset($_GET['id'])) {
            // Haal het nieuwsbericht-ID op uit de URL
            $newsId = $_GET['id'];

            // Query om het nieuwsbericht op te halen op basis van het nieuwsbericht-ID
            $sql = "SELECT titel, inhoud, datum, afbeelding_url FROM nieuwsberichten WHERE id = $newsId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $titel = $row["titel"];
                $inhoud = $row["inhoud"];
                $datum = date("l j F Y", strtotime($row["datum"]));
                $afbeelding_url = $row["afbeelding_url"];

                // Hieronder wordt de nieuwsberichtinformatie weergegeven
                echo '<h1 class="news-title">' . $titel . '</h1>';
                echo '<p class="news-date">' . translateDate(date("l j F Y", strtotime($row["datum"]))) . '</p>';
                echo '<img src="' . $afbeelding_url . '" alt="' . $titel . '" class="news-image">';
                echo '<div class="news-content">' . $inhoud . '</div>';
            } else {
                echo "Nieuwsbericht niet gevonden.";
            }
        } else {
            echo "Nieuwsbericht-ID niet gespecificeerd.";
        }

        // Sluit de databaseverbinding
        $conn->close();
        ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
