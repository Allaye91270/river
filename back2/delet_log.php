<?php
include "../template/header2.php";
require "../core/functions.php";
session_start();

$connection = connectDB();

if (!$connection) {
    die("Erreur de connexion à la base de données");
}

// Vérifier si l'ID de la réservation à supprimer est passé en paramètre
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    try {
        // Delete the associated reserved dates first
        $deleteReservedDatesQuery = "DELETE FROM apn_reserved_dates WHERE ID_Logement = :id";
        $deleteReservedDatesStmt = $connection->prepare($deleteReservedDatesQuery);
        $deleteReservedDatesStmt->bindParam(':id', $eventId);
        $deleteReservedDatesStmt->execute();

        // Préparer et exécuter la requête de suppression du logement
        $deleteLogementQuery = "DELETE FROM apn_logement WHERE ID_logement = :id";
        $deleteLogementStmt = $connection->prepare($deleteLogementQuery);
        $deleteLogementStmt->bindParam(':id', $eventId);
        $deleteLogementStmt->execute();

        // Rediriger vers la page de gestion des réservations après la suppression
        header('Location: ../back/logement.php');
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
