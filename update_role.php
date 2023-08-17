<?php
include "../template/header.php";
require "../core/functions.php";
session_start();

$connection = connectDB(); // Utilisez la fonction connectDB() pour obtenir la connexion PDO

if (!$connection) {
    // Gérer l'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $role = $_POST['role'];

    // Mettre à jour le rôle de l'utilisateur
    $query = $connection->prepare("UPDATE apn_utilisateurs SET ROLE = :role WHERE id = :userId");
    $query->bindParam(':role', $role);
    $query->bindParam(':userId', $userId);

    try {
        $query->execute();
        echo "Le rôle de l'utilisateur a été mis à jour avec succès.";

        // Rediriger vers la page user_admin.php
        header('Location: user_admin.php');
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du rôle de l'utilisateur : " . $e->getMessage();
        // Arrêter l'exécution du script ou effectuer une autre gestion d'erreur si nécessaire
    }
}

// Fermeture de la connexion à la base de données
$connection = null;
?>
