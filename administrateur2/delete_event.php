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

// Vérifier si l'ID de l'événement à supprimer est passé en paramètre
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Préparer et exécuter la requête de suppression
    $query = $connection->prepare("DELETE FROM apn_evenements WHERE IDEVENEMENT = :id");
    $query->bindParam(':id', $eventId);
    $query->execute();

    // Rediriger vers la page de gestion des événements après la suppression
    header('Location: evenement.php');
    exit();
} else {
    // Rediriger vers la page de gestion des événements si l'ID de l'événement n'est pas spécifié
    header('Location: evenement.php');
    exit();
}
?>
