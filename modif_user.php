<?php
include "../template/header.php";
require "../core/functions.php";
session_start();

$connection = connectDB();

if (!$connection) {
    die("Erreur de connexion à la base de données");
}

$query = "SELECT * FROM apn_utilisateurs WHERE id = :id";
$stmt = $connection->prepare($query);
$stmt->bindParam(':id', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newFirstName = $_POST['FIRSTNAME'];
    $newLastName = $_POST['LASTNAME'];
    $newEmail = $_POST['EMAIL'];
    $newBirthday = $_POST['BIRTHDAY'];

    $updateQuery = "UPDATE apn_utilisateurs SET FIRSTNAME = :first_name, LASTNAME = :last_name, EMAIL = :email, BIRTHDAY = :birthday WHERE id = :id";
    $updateStmt = $connection->prepare($updateQuery);
    $updateStmt->bindParam(':first_name', $newFirstName, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $newLastName, PDO::PARAM_STR);
    $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':birthday', $newBirthday, PDO::PARAM_STR);
    $updateStmt->bindParam(':id', $userID, PDO::PARAM_INT);
    $updateStmt->execute();

    header("Location: user_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un utilisateur</title>
</head>
<body>
    <h1>Modifier un utilisateur</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label>Prenom:</label>
        <input type="text" name="FIRSTNAME" value="<?php echo isset($user['FIRSTNAME']) ? $user['FIRSTNAME'] : ''; ?>"><br><br>

        <label>Nom:</label>
        <input type="text" name="LASTNAME" value="<?php echo isset($user['LASTNAME']) ? $user['LASTNAME'] : ''; ?>"><br><br>

        <label>Email:</label>
        <input type="text" name="EMAIL" value="<?php echo isset($user['EMAIL']) ? $user['EMAIL'] : ''; ?>"><br><br>

        <label>Date de naissance:</label>
        <input type="text" name="BIRTHDAY" value="<?php echo isset($user['BIRTHDAY']) ? $user['BIRTHDAY'] : ''; ?>"><br><br>

        <input type="hidden" name="id" value="<?php echo $userID; ?>">

        <input type="submit" value="Modifier">
    </form>
</body>
</html>
