<?php
// Haal de gegevens uit het formulier
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

// Zorg ervoor dat de gebruiker een geslacht selecteert
if (isset($_POST['gender'])) {
    $gender = $_POST['gender'];
} else {
    // Als geen geslacht is geselecteerd, kun je bijvoorbeeld een foutmelding geven of een standaard waarde instellen
    echo "Geslacht is verplicht!";
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];
$number = $_POST['number'];

// Database verbinding
$conn = new mysqli('localhost', 'root', '', 'test');

// Controleer de verbinding
if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
} else {
    // Wachtwoord hashen voor veiligheid
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Voorbereiden van de SQL query
    $stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $hashed_password, $number);

    // Voer de query uit
    if ($stmt->execute()) {
        // Na succesvolle registratie, doorsturen naar steam.html
        header("Location: steam.html");
        exit(); // Zorg ervoor dat de uitvoering van het script stopt
    } else {
        echo "Er is een fout opgetreden: " . $stmt->error;
    }

    // Sluit de statement en de databaseverbinding
    $stmt->close();
    $conn->close();
}
?>
