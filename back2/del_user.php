<?php
include "../template/header2.php";
require "../core/functions.php";
session_start();

$connection = connectDB();

if (!$connection) {
    die("Erreur de connexion à la base de données");
}

if (isset($_GET['id'])) {
    $email = $_GET['id'];

    try {
        // Supprimer l'utilisateur de la table des utilisateurs
        $query = $connection->prepare("DELETE FROM apn_utilisateurs WHERE EMAIL = :email");
        $query->bindParam(':email', $email);
        $query->execute();
 
        // Rediriger vers la liste des utilisateurs
        header('Location: ../administrateur\user_admin.php');
        exit(); // Ajout de cette ligne pour arrêter l'exécution du script après la redirection
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
        // Arrêter l'exécution du script ou effectuer une autre gestion d'erreur si nécessaire
    }
}
?>
