<?php
include "../template/header2.php";
require "../core/functions.php";
session_start();

$connection = connectDB();

if (!$connection) {
    die("Erreur de connexion à la base de données");
}

$point_arret = $Nom = $Date_Debut = $Date_Fin = $customer_Name = $customer_Email = '';
$reservedLogementIds = array();

if (isset($_POST['ajouterLogement'])) {
    $point_arret = $_POST['point_arret'];
    $Nom = $_POST['Nom'];
    $Date_Debut = $_POST['dateDebut'];
    $Date_Fin = $_POST['dateFin'];
    $customer_Name = $_POST['customer_Name'];
    $customer_Email = $_POST['customer_Email'];

    $reservedQuery = "SELECT ID_Logement FROM apn_reserved_dates WHERE Reserved_Date BETWEEN :Date_Debut AND :Date_Fin";
    $reservedStmt = $connection->prepare($reservedQuery);
    $reservedStmt->bindValue(':Date_Debut', $Date_Debut);
    $reservedStmt->bindValue(':Date_Fin', $Date_Fin);
    $reservedStmt->execute();
    $reservedLogementIds = $reservedStmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($reservedLogementIds) > 0) {
        // Dates are already reserved, handle accordingly (e.g., show an error message)
        // You can add your error handling here
        echo "Ces dates sont déjà réservées.";
    } else {
        // Insert the new logement
        $query = "INSERT INTO apn_logement (point_arret, Nom, Date_Debut, Date_Fin, customer_Name, customer_Email) VALUES (:point_arret, :Nom, :Date_Debut, :Date_Fin, :customer_Name, :customer_Email)";
        $stmt = $connection->prepare($query);
        $stmt->bindValue(':point_arret', $point_arret);
        $stmt->bindValue(':Nom', $Nom);
        $stmt->bindValue(':Date_Debut', $Date_Debut);
        $stmt->bindValue(':Date_Fin', $Date_Fin);
        $stmt->bindValue(':customer_Name', $customer_Name);
        $stmt->bindValue(':customer_Email', $customer_Email);
        $stmt->execute();

        // Get the last inserted ID for the new logement
        $logementId = $connection->lastInsertId();

        // Insert the reserved dates into reserved_dates table
        $insertReservedDateQuery = "INSERT INTO apn_reserved_dates (ID_Logement, Reserved_Date) VALUES (:logementId, :reservedDate)";
        $insertReservedDateStmt = $connection->prepare($insertReservedDateQuery);
        $insertReservedDateStmt->bindValue(':logementId', $logementId);
        $insertReservedDateStmt->bindValue(':reservedDate', $Date_Debut); // Use the starting date for simplicity
        $insertReservedDateStmt->execute();
    }
}

$query = "SELECT * FROM apn_logement";
$stmt = $connection->prepare($query);
$stmt->execute();
$logements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Logements par Point d'Arrêt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, input[type="date"], input[type="text"], input[type="email"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        select {
            height: 38px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Ajouter un Logement</h2>
    <form method="POST" action="">
        <label for="point_arret">Point d'Arrêt :</label>
        <select name="point_arret">
            <option value="" disabled selected>Sélectionnez un point</option>
            <option value="Point Halland">Point Halland</option>
            <option value="Point Messi">Point Messi</option>
            <option value="Point Dembouz">Point Dembouz</option>
        </select><br>

        <label for="Nom">Logement :</label>
        <select name="Nom">
            <option value="" disabled selected>Sélectionnez un hébergement</option>
            <option value="Paris">Paris</option>
            <option value="Lyon">Lyon</option>
            <option value="Marseille">Marseille</option>
        </select><br>

        <label for="dateDebut">Date de Début :</label>
        <input type="date" name="dateDebut" min="<?= date('Y-m-d') ?>"><br>

        <label for="dateFin">Date de Fin :</label>
        <input type="date" name="dateFin" min="<?= date('Y-m-d') ?>"><br>

        <label for="customer_Name">Nom du client :</label>
        <input type="text" id="customer_Name" name="customer_Name" value="<?= htmlspecialchars($customer_Name) ?>"><br>

        <label for="customer_Email">Email du client :</label>
        <input type="email" id="customer_Email" name="customer_Email" value="<?= htmlspecialchars($customer_Email) ?>"><br>

        <input type="submit" name="ajouterLogement" value="Ajouter">
    </form>
    <a href="../administrateur/user_admin.php" class="btn btn-primary back-button">Retour</a>

    <h2>Réservations existantes :</h2>
    <table class="reservation-table">
        <tr>
            <th>ID</th>
            <th>Point d'Arrêt</th>
            <th>Logement</th>
            <th>Date de Début</th>
            <th>Date de Fin</th>
            <th>Nom du client</th>
            <th>Email du client</th>
            <th>Action</th>
        </tr>
        <?php foreach ($logements as $logement): ?>
            <?php
            $isDatesReserved = in_array($logement['ID_Logement'], $reservedLogementIds);
            if (!$isDatesReserved):
            ?>
                <tr>
                    <td><?= htmlspecialchars($logement['ID_Logement']) ?></td>
                    <td><?= htmlspecialchars($logement['point_arret']) ?></td>
                    <td><?= htmlspecialchars($logement['Nom']) ?></td>
                    <td><?= htmlspecialchars($logement['Date_Debut']) ?></td>
                    <td><?= htmlspecialchars($logement['Date_Fin']) ?></td>
                    <td><?= htmlspecialchars($logement['customer_Name']) ?></td>
                    <td><?= htmlspecialchars($logement['customer_Email']) ?></td>
                    <td>
                        <a href="../back2/edit_log.php?id=<?= $logement['ID_Logement'] ?>">Modifier</a>
                        <a href="../back2/delet_log.php?id=<?= $logement['ID_Logement'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>
