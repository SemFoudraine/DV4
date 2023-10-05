<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donatieformulier</title>
</head>

<body>
    <?php
    include 'header.php'
    ?>

<?php
// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verkrijg de ingediende gegevens
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $bedrag = $_POST['bedrag'];

    // Verbinding maken met de database
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'donatie_database';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Verbinding met de database mislukt: " . $conn->connect_error);
    }

    // Controleer of er al een donatie van dit e-mailadres is
    $check_sql = "SELECT bedrag FROM donaties WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    // Initialiseer $update_stmt buiten de if-else blokken
    $update_stmt = null;

    if ($check_result->num_rows > 0) {
        // Update het bedrag als er al een donatie is van dit e-mailadres
        $update_sql = "UPDATE donaties SET bedrag = bedrag + ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ds", $bedrag, $email);

        if ($update_stmt->execute()) {
            echo "Bedankt voor je donatie!";
        } else {
            echo "Fout bij het bijwerken van de donatie: " . $conn->error;
        }
    } else {
        // Voeg een nieuwe donatie toe als er nog geen donatie is van dit e-mailadres
        $insert_sql = "INSERT INTO donaties (naam, email, bedrag) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssd", $naam, $email, $bedrag);

        if ($insert_stmt->execute()) {
            echo "Bedankt voor je donatie!";
        } else {
            echo "Fout bij het toevoegen van de donatie: " . $conn->error;
        }
    }
}
?>
    <?php
    // Verbinding maken met de database
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'donatie_database';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Verbinding met de database mislukt: " . $conn->connect_error);
    }

    // Controleer of het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verkrijg de ingediende gegevens
        $naam = $_POST['naam'];
        $email = $_POST['email'];
        $bedrag = $_POST['bedrag'];
    }

    ?>

<div class="container-donaties">
        <div class="form">
            <h1 id="h1donatie">Donatieformulier</h1>
            <form action="doneer.php" method="post">
                <label for="naam">Naam:</label>
                <input type="text" id="naam" name="naam" required><br><br>

                <label for="email">E-mailadres:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="bedrag">Bedrag:</label>
                <input type="number" id="bedrag" name="bedrag" required><br><br>

                <button type="submit">Doneer</button>
            </form>
        </div>

        <div class="donaties">
            <div class="donaties-box">
                <h1 id="h1donatie">Laatste 5 Donaties</h1>
                <ul>
                    <!-- Hier worden de laatste 5 donaties weergegeven -->
                    <?php
                    // Voer een SQL-query uit om de laatste 5 donaties op te halen
                    $sql = "SELECT naam, bedrag FROM donaties ORDER BY id DESC LIMIT 5";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<li>{$row['naam']} doneerde €{$row['bedrag']}</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="donaties-box">
                <h1 id="h1donatie">5 Hoogste Donaties</h1>
                <ul>
                    <!-- Hier worden de 5 hoogste donaties weergegeven -->
                    <?php
                    // Voer een SQL-query uit om de 5 hoogste donaties op te halen
                    $sql = "SELECT naam, bedrag FROM donaties ORDER BY bedrag DESC LIMIT 5";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<li>{$row['naam']} doneerde €{$row['bedrag']}</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
 
    <?php
    // Sluit de databaseverbinding
    $conn->close();
    ?>
    <?php
    include 'footer.php'
    ?>
</body>

</html>