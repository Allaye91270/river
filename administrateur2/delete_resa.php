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

// Vérifier si l'ID de la réservation à supprimer est passé en paramètre
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    try {
        // Préparer et exécuter la requête de suppression
        $query = $connection->prepare("DELETE FROM apn_reservation WHERE IDRESERVATION = :id");
        $query->bindParam(':id', $eventId);
        $query->execute();

        // Rediriger vers la page de gestion des réservations après la suppression
        header('Location: Reservation.php');
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de la réservation : " . $e->getMessage();
        // Arrêter l'exécution du script ou effectuer une autre gestion d'erreur si nécessaire
    }
} else {
    // Rediriger vers la page de gestion des réservations si l'ID de la réservation n'est pas spécifié
    header('Location: Reservation.php');
    exit();
}
?>
