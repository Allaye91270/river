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
    // Arrêter l'exécution du script ou effectuer une autre gestion d'erreur si nécessaire
}

// Vérifier si le formulaire d'ajout d'événement a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $titre = isset($_POST['titre']) ? $_POST['titre'] : null;   
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Vérifier si le titre est vide
    if (empty($titre)) {
        echo "Le titre est obligatoire.";
        // Arrêter l'exécution du script ou effectuer une autre gestion d'erreur si nécessaire
        exit();
    }

    // Préparer et exécuter la requête d'insertion
    $query = $connection->prepare("INSERT INTO apn_evenements (titre, description, date) VALUES (:titre, :description, :date)");
    $query->bindParam(':titre', $titre);
    $query->bindParam(':description', $description);
    $query->bindParam(':date', $date);
    $query->execute();

    // Rediriger vers la page de gestion des événements après l'ajout
    header('Location: evenement.php');
    exit();
}

// Exécutez la requête SELECT pour récupérer les événements
$query = $connection->query("SELECT * FROM apn_evenements");
$events = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des événements</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>


    <form method="POST">
        <h2>Gestion des événements</h2>
        <label for="titre">Titre :</label>
        <select name="titre" id="titre" required>
            <option value="mariage">Mariage</option>
            <option value="anniversaire">Anniversaire</option>
            <option value="autre">Autre</option>
        </select>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>

        <label for="date">Date :</label>
        <input type="date" name="date" id="date" required>

        <button type="submit">Ajouter</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($events as $event) : ?>
            <tr>
                <td><?= $event['IDEVENEMENT'] ?></td>
                <td><?= $event['TITRE'] ?></td>
                <td><?= $event['DESCRIPTION'] ?></td>
                <td><?= $event['DATE'] ?></td>
                <td>
                    <a href="edit_event.php?id=<?= $event['IDEVENEMENT'] ?>">Modifier</a>
                    <a href="delete_event.php?id=<?= $event['IDEVENEMENT'] ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="../administrateur/user_admin.php" class="btn btn-primary back-button">Retour</a>
</body>
</html>
