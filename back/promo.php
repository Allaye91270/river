<?php
// Inclure les fichiers nécessaires, comme header2.php et functions.php
include "../template/header2.php";
require "../core/functions.php";
session_start();

$connection = connectDB();

if (!$connection) {
    die("Erreur de connexion à la base de données");
}

// Traitement du formulaire pour ajouter une nouvelle promotion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomLogement = htmlspecialchars($_POST['Nom']);
    $pointArret = htmlspecialchars($_POST['point_arret']);
    $debut = $_POST['debut'];
    $fin = $_POST['fin'];
    $saison = htmlspecialchars($_POST['saison']);
    $pourcentageReduction = $_POST['pourcentage_reduction'];

    if ($pointArret && $nomLogement && $debut && $fin && $saison && $pourcentageReduction) {
        $query = "INSERT INTO apn_offre (Nom, Point_Arret, Date_Debut, Date_Fin, Saison, Pourcentage_Reduction) VALUES (:Nom, :Point_Arret,:Date_Debut, :Date_Fin, :Saison, :Pourcentage_Reduction)";
        $stmt = $connection->prepare($query);
        $stmt->bindValue(':Nom', $nomLogement);
        $stmt->bindValue(':Point_Arret', $pointArret);
        $stmt->bindValue(':Date_Debut', $debut);
        $stmt->bindValue(':Date_Fin', $fin);
        $stmt->bindValue(':Saison', $saison);
        $stmt->bindValue(':Pourcentage_Reduction', $pourcentageReduction);

        if ($stmt->execute()) {
            echo "Nouvelle promotion ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la promotion : " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Tous les champs doivent être remplis.";
    }
}

$query = "SELECT * FROM apn_offre";
$stmt = $connection->prepare($query);
$stmt->execute();
$offre = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fermer la connexion à la base de données
$connection = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Offres Promotionnelles</title>
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

<h1>Offres Promotionnelles</h1>

<!-- Formulaire d'ajout d'une nouvelle promotion -->
<h2>Ajouter une nouvelle promotion</h2>
<form method="post">
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

    <label for="debut">Date de début :</label>
    <input type="date" id="debut" name="debut" required><br>
    <label for="fin">Date de fin :</label>
    <input type="date" id="fin" name="fin" required><br>
    
    <label for="saison">Saison :</label>
    <select name="saison">
        <option value="" disabled selected>Sélectionnez une saison</option>
        <option value="Printemps">Printemps</option>
        <option value="Été">Été</option>
        <option value="Automne">Automne</option>
        <option value="Hiver">Hiver</option>
    </select><br>
    
    <label for="pourcentage_reduction">Pourcentage de réduction :</label>
    <input type="number" id="pourcentage_reduction" name="pourcentage_reduction" required><br>
    <button type="submit">Ajouter Promotion</button>
</form>

<a href="../administrateur/user_admin.php" class="btn btn-primary back-button">Retour</a>

<h2>Réservations existantes :</h2>
<table class="reservation-table">
    <tr>
        <th>ID</th>
        <th>Point d'Arrêt</th>
        <th>Nom</th>
        <th>Date_Debut</th>
        <th>Date de Fin</th>
        <th>Saison</th>
        <th>Pourcentage_Reduction</th>
        <th>Action</th>
    </tr>
    <?php foreach ($offre as $offre): ?>
        <tr>
            <td><?= htmlspecialchars($offre['ID_Offre']) ?></td>
            <td><?= htmlspecialchars($offre['Point_Arret']) ?></td>
            <td><?= htmlspecialchars($offre['Nom']) ?></td>
            <td><?= htmlspecialchars($offre['Date_Debut']) ?></td>
            <td><?= htmlspecialchars($offre['Date_Fin']) ?></td>
            <td><?= htmlspecialchars($offre['Saison']) ?></td>
            <td><?= htmlspecialchars($offre['Pourcentage_Reduction']) ?></td>
            <td>
                <a href="../back2\edit_log.php?id=<?= $offre['ID_Offre'] ?>">Modifier</a>
                <a href="../back2\delet_log.php?id=<?= $offre['ID_Offre'] ?>">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
