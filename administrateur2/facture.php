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

// Récupérer toutes les factures des clients depuis la base de données
$query = "SELECT * FROM apn_facture";
$stmt = $connection->prepare($query);
$stmt->execute();
$factures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des factures</title>
</head>
<body>
    <h1>Liste des factures</h1>

    <table>
        <tr>
            <th>Numéro de facture</th>
            <th>Date</th>
            <th>Montant</th>
            <th>Client</th>
        </tr>
        <?php foreach ($factures as $facture) : ?>
        <tr>
            <td><?php echo $facture["numero_facture"]; ?></td>
            <td><?php echo $facture["date"]; ?></td>
            <td><?php echo $facture["montant"]; ?></td>
            <td><?php echo $facture["client"]; ?></td>
        </tr>
        <?php endforeach; ?>
        
    </table>
    <a href="../administrateur/user_admin.php" class="btn btn-primary back-button">Retour</a>
</body>
</html>
