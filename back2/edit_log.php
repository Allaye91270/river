<?php
include "../template/header2.php";
require "../core/functions.php";
session_start();

$connection = connectDB();

if (!$connection) {
    die("Erreur de connexion à la base de données");
}

// Vérifier si l'ID de l'événement à modifier est passé en paramètre
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Vérifier si le formulaire de modification a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $point_arret = $_POST['point_arret'];
        $Nom = $_POST['Nom'];
        $Date_Debut = $_POST['dateDebut'];
        $Date_Fin = $_POST['datefin'];
        $customer_Name = $_POST['customer_Name'];
        $customer_Email = $_POST['customer_Email'];

        // Préparer et exécuter la requête de mise à jour
        $query = $connection->prepare("UPDATE apn_logement SET point_arret = :point_arret, Nom = :Nom, Date_Debut = :Date_Debut , Date_Fin = :Date_Fin, customer_Name = :customer_Name , customer_Email = :customer_Email WHERE ID_logement = :id");
        $query->bindParam(':point_arret', $point_arret);
        $query->bindParam(':Nom', $Nom);
        $query->bindParam(':Date_Debut', $Date_Debut);
        $query->bindParam(':Date_Fin', $Date_Fin);
        $query->bindParam(':customer_Name', $customer_Name);
        $query->bindParam(':customer_Email', $customer_Email);
        $query->bindParam(':id', $eventId);
        $query->execute();

        // Rediriger vers la page de gestion des événements après la modification
        header('Location: ../back/logement.php');
        exit();
    }

    // Récupérer les informations de l'événement à modifier
    $query = $connection->prepare("SELECT * FROM apn_logement WHERE ID_logement = :id");
    $query->bindParam(':id', $eventId);
    $query->execute();
    $event = $query->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'événement existe
    if (!$event) {
        // Rediriger vers la page de gestion des événements si l'événement n'existe pas
        header('Location: ../back/logement.php');
        exit();
    }
} else {
    // Rediriger vers la page de gestion des événements si l'ID de l'événement n'est pas spécifié
    header('Location: ../back/logement.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un événement</title>
    <style>
         <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            background-color: #ffffff;
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .back-button {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            padding: 8px 15px;
            background-color: #ccc;
            color: #ffffff;
            border-radius: 3px;
        }

        .back-button:hover {
            background-color: #999;
        }
    </style>
    </style>
</head>
<body>
    <h1>Modifier un événement</h1>

    <form method="POST">
       
        <label for="point_arret">Point Arrêt:</label>
        <select name="point_arret">
            <option value="" disabled selected>Sélectionnez un point</option>
            <option value="Point Halland" <?= ($event['point_arret'] == 'Point Halland') ? 'selected' : '' ?>>Point Halland</option>
            <option value="Point Messi" <?= ($event['point_arret'] == 'Point Messi') ? 'selected' : '' ?>>Point Messi</option>
            <option value="Point Dembouz" <?= ($event['point_arret'] == 'Point Dembouz') ? 'selected' : '' ?>>Point Dembouz</option>
        </select><br>

        <label for="Nom">Nom de l'arrêt :</label>
        <select name="Nom">
            <option value="" disabled selected>Sélectionnez un hébergement</option>
            <option value="Paris" <?= ($event['Nom'] == 'Paris') ? 'selected' : '' ?>>Paris</option>
            <option value="Lyon" <?= ($event['Nom'] == 'Lyon') ? 'selected' : '' ?>>Lyon</option>
            <option value="Marseille" <?= ($event['Nom'] == 'Marseille') ? 'selected' : '' ?>>Marseille</option>
        </select><br>

        <label for="Date_Debut">Date de début :</label>
        <input type="date" name="dateDebut" value="<?= $event['Date_Debut'] ?>"><br>

        <label for="Date_Fin">Date de fin:</label>
        <input type="date" name="datefin" value="<?= $event['Date_Fin'] ?>"><br>

        <label for="customer_Name">Nom:</label>
        <input type="text" name="customer_Name" id="customer_Name" value="<?= $event['customer_Name'] ?>" required>

        <label for="customer_Email">Email:</label>
        <input type="email" name="customer_Email" id="customer_Email" value="<?= $event['customer_Email'] ?>" required>

        <button type="submit">Modifier</button>
    </form>
    <a href="../back/logement.php" class="back-button">Retour</a>
</body>
</html>
