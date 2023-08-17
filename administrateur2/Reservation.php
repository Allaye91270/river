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

function createReservation($connection, $date, $startTime, $endTime, $customerName, $customerEmail)
{
    $query = "INSERT INTO apn_reservation (date, start_Time, end_Time, customer_Name, customer_Email) VALUES (:date, :start_Time, :end_Time, :customer_Name, :customer_Email)";
    $stmt = $connection->prepare($query);
    $stmt->bindValue(':date', $date ?: null);
    $stmt->bindValue(':start_Time', $startTime ?: null);
    $stmt->bindValue(':end_Time', $endTime ?: null);
    $stmt->bindValue(':customer_Name', $customerName ?: null);
    $stmt->bindValue(':customer_Email', $customerEmail ?: null);
    $stmt->execute();
}

// Vérifier si le formulaire a été soumis pour créer une réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $startTime = $_POST['start_Time'];
    $endTime = $_POST['end_Time'];
    $customerName = $_POST['customer_Name'];
    $customerEmail = $_POST['customer_Email'];

    // Convertir les heures de début et de fin en un format de date et d'heure valide
    $startTime = DateTime::createFromFormat('H:i', $startTime)->format('Y-m-d H:i:s');
    $endTime = DateTime::createFromFormat('H:i', $endTime)->format('Y-m-d H:i:s');

    createReservation($connection, $date, $startTime, $endTime, $customerName, $customerEmail);
}

// Récupérer toutes les réservations existantes
$query = "SELECT * FROM apn_reservation";
$stmt = $connection->prepare($query);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Réservation</title>
    <style>
        .reservation-table {
            border-collapse: collapse;
            width: 100%;
        }

        .reservation-table th, .reservation-table td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Réservation</h1>
    <form method="POST" action="">
        <label for="date">Date :</label>
        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
        <br><br>
        <label for="start_Time">Heure de début :</label>
        <input type="time" id="start_Time" name="start_Time" value="<?php echo date('H:i'); ?>">
        <br><br>
        <label for="end_Time">Heure de fin :</label>
        <input type="time" id="end_Time" name="end_Time" value="<?php echo date('H:i'); ?>">
        <br><br>
        <label for="customer_Name">Nom du client :</label>
        <input type="text" id="customer_Name" name="customer_Name">
        <br><br>
        <label for="customer_Email">Email du client :</label>
        <input type="email" id="customer_Email" name="customer_Email">
        <br><br>
        <input type="submit" name="submit" value="Réserver">
    </form>

    <h2>Réservations existantes :</h2>
    <table class="reservation-table">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <th>Nom du client</th>
            <th>Email du client</th>
            <th>Action</th>
        </tr>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo $reservation['IDRESERVATION']; ?></td>
                <td><?php echo $reservation['date']; ?></td>
                <td><?php echo $reservation['start_Time']; ?></td>
                <td><?php echo $reservation['end_Time']; ?></td>
                <td><?php echo $reservation['customer_Name']; ?></td>
                <td><?php echo $reservation['customer_Email']; ?></td>
                <td>
                    <a href="edit_resa.php?id=<?= $reservation['IDRESERVATION'] ?>">Modifier</a>
                    <a href="delete_resa.php?id=<?= $reservation['IDRESERVATION'] ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="../administrateur/user_admin.php" class="btn btn-primary back-button">Retour</a>
</body>
</html>
