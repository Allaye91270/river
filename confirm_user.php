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

// Récupérer les valeurs du formulaire
$userID = $_POST['userID'];
$newEmail = $_POST['email'];
$newFirstName = $_POST['firstname'];
$newLastName = $_POST['lastname'];
$newPhone = $_POST['birthday'];

// Mettre à jour les informations de l'utilisateur dans la base de données
$query = "UPDATE apn_utilisateurs SET email = :email, firstname = :firstname, lastname = :lastname, birthday = :birthday WHERE id = :userID";
$stmt = $connection->prepare($query);
$stmt->bindParam(':email', $newEmail);
$stmt->bindParam(':firstname', $newFirstName);
$stmt->bindParam(':lastname', $newLastName);
$stmt->bindParam(':birthday', $newbirthday);
$stmt->bindParam(':userID', $userID);
$stmt->execute();

// Rediriger vers une autre page après la modification
header("Location: user_admin.php");
exit();
?>
