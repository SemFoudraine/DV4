<?php
// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donatie_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleren op fouten in de verbinding
if ($conn->connect_error) {
    die("Verbinding met de database is mislukt: " . $conn->connect_error);
}

// Functie om de Engelse datum naar Nederlands te vertalen
function translateDate($englishDate)
{
    $englishMonths = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $dutchMonths = array("januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");
    $englishDays = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $dutchDays = array("maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag", "zondag");

    $englishDate = str_replace($englishMonths, $dutchMonths, $englishDate);
    $englishDate = str_replace($englishDays, $dutchDays, $englishDate);

    return $englishDate;
}

// Query om nieuwsberichten op te halen
$sql = "SELECT id, datum, titel, inhoud, afbeelding_url FROM nieuwsberichten ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container-nieuws">
        <div class="nieuws-container">
            <?php
            // Controleren of de query resultaten heeft opgeleverd
            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<figure class="nieuws">';
                    echo '<img src="' . $row["afbeelding_url"] . '" al  t="niet gevonden" />';
                    echo '<div class="date">' . translateDate(date("l j F Y", strtotime($row["datum"]))) . '</div>';
                    echo '<figcaption>';
                    echo '<h2>' . $row["titel"] . '</h2>';
                    echo '<p>' . $row["inhoud"] . '</p>';
                    // Voeg de link toe met het nieuwsbericht-ID als parameter
                    echo '<a href="nieuws_detail.php?id=' . $row["id"] . '" class="read-more">Bekijk Artikel</a>';
                    echo '</figcaption>';
                    echo '</figure>';
                }
            } else {
                echo "Geen nieuwsberichten gevonden.";
            }

            // Sluit de databaseverbinding
            $conn->close();
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>