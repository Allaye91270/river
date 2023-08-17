<?php
include "../template/header2.php";
// Configuration de la base de données
session_start();

// Connexion à la base de données
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

// Requête pour récupérer tous les utilisateurs
$query = "SELECT * FROM apn_utilisateurs";
$result = $connection->query($query);

if ($result->rowCount() > 0) {
    // Affichage de la liste des utilisateurs
    echo "<h1>Liste des utilisateurs</h1>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Email</th><th>Action</th></tr>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $email = $row['EMAIL'];

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$email</td>";
        echo "<td><a href='envoyer_email.php?id=$id'>Envoyer l'e-mail</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucun utilisateur trouvé";
}

// Fermeture de la connexion à la base de données
$connection = null;
?>
<a href="../administrateur/user_admin.php" class="btn btn-primary back-button">Retour</a>