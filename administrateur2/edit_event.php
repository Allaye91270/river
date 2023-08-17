<?php
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

// Vérifier si l'ID de l'événement à modifier est passé en paramètre
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Vérifier si le formulaire de modification a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $date = $_POST['date'];

        // Préparer et exécuter la requête de mise à jour
        $query = $connection->prepare("UPDATE apn_evenements SET TITRE = :titre, DESCRIPTION = :description, DATE = :date WHERE IDEVENEMENT = :id");
        $query->bindParam(':titre', $titre);
        $query->bindParam(':description', $description);
        $query->bindParam(':date', $date);
        $query->bindParam(':id', $eventId);
        $query->execute();

        // Rediriger vers la page de gestion des événements après la modification
        header('Location: evenement.php');
        exit();
    }

    // Récupérer les informations de l'événement à modifier
    $query = $connection->prepare("SELECT * FROM apn_evenements WHERE IDEVENEMENT = :id");
    $query->bindParam(':id', $eventId);
    $query->execute();
    $event = $query->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'événement existe
    if (!$event) {
        // Rediriger vers la page de gestion des événements si l'événement n'existe pas
        header('Location: evenement.php');
        exit();
    }
} else {
    // Rediriger vers la page de gestion des événements si l'ID de l'événement n'est pas spécifié
    header('Location: evenement.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un événement</title>
</head>
<body>
    <h1>Modifier un événement</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $event['IDEVENEMENT'] ?>">

        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" value="<?= $event['TITRE'] ?>" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required><?= $event['DESCRIPTION'] ?></textarea>

        <label for="date">Date :</label>
        <input type="date" name="date" id="date" value="<?= $event['DATE'] ?>" required>

        <button type="submit">Modifier</button>
    </form>
    <a href="evenement.php" class="btn btn-primary back-button">Retour</a>
</body>
</html>
