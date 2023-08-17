<?php
include "../template/header2.php";

// Connectez-vous à votre base de données
$dsn = "mysql:host=193.70.42.147;dbname=PA;port=3306";
$username = "palacio";
$password = "palacio";

try {
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}

function updateReservation($connection, $reservationId, $date, $lastname, $firstname, $startTime, $endTime, $customerName, $customerEmail)
{
    $query = "UPDATE apn_reservation SET date = :date, lastname = :lastname, firstname = :firstname, start_Time = :start_Time, end_Time = :end_Time, customer_Name = :customer_Name, customer_Email = :customer_Email WHERE IDRESERVATION = :reservationId";
    $stmt = $connection->prepare($query);
    $stmt->bindValue(':date', $date ?: null);
    $stmt->bindValue(':lastname', $lastname ?: null);
    $stmt->bindValue(':firstname', $firstname ?: null);
    $stmt->bindValue(':start_Time', $startTime ?: null);
    $stmt->bindValue(':end_Time', $endTime ?: null);
    $stmt->bindValue(':customer_Name', $customerName ?: null);
    $stmt->bindValue(':customer_Email', $customerEmail ?: null);
    $stmt->bindValue(':reservationId', $reservationId);
    $stmt->execute();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $reservationId = $_POST["reservation_id"];
    $nouvelleDate = $_POST["nouvelle_date"];
    $nouveauNom = $_POST["nouveau_nom"];
    $nouveauEmail = $_POST["nouveau_email"];

    // TODO: Effectuer les validations nécessaires sur les données reçues

    // Convertir la nouvelle date en un format de date valide si nécessaire
    $nouvelleDate = DateTime::createFromFormat('Y-m-d', $nouvelleDate)->format('Y-m-d');

    // Mettre à jour la réservation dans la base de données avec les nouvelles informations
    updateReservation($connection, $reservationId, $nouvelleDate, $nouveauNom, $nouveauNom, $nouveauNom, $nouveauNom, $nouveauEmail);

    // Rediriger vers une page de succès ou afficher un message de réussite
    header("Location: edit_resa.php");
    exit;
} else {
    // Si le formulaire n'a pas été soumis, récupérer l'ID de réservation à partir des paramètres de l'URL
    $reservationId = $_GET["id"];

    // TODO: Récupérer les informations de la réservation à partir de la base de données

    // TODO: Afficher le formulaire avec les informations actuelles de la réservation
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier la réservation</title>
</head>
<body>
    <h1>Modifier la réservation</h1>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="reservation_id" value="<?php echo $reservationId; ?>">

        <label for="nouvelle_date">Nouvelle date :</label>
        <input type="date" name="nouvelle_date" required><br>

        <label for="nouveau_nom">Nouveau nom :</label>
        <input type="text" name="nouveau_nom" required><br>

        <label for="nouveau_email">Nouveau email :</label>
        <input type="email" name="nouveau_email" required><br>

        <input type="submit" value="Modifier la réservation">
    </form>
    <a href="reservation.php" class="btn btn-primary back-button">Retour</a>
</body>
</html>
