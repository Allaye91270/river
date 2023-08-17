<?php
session_start();

if (isset($_GET['id'])) {
    $email = $_GET['id'];

    if (isset($_POST['confirm'])) {
        // Bannir l'utilisateur
        $dsn = "mysql:host=193.70.42.147;dbname=PA;port=3306";
        $username = "palacio";
        $password = "palacio";

        try {
            $connection = new PDO($dsn, $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_POST['confirm'] == 1) {
                // Bannir l'utilisateur
                $query = $connection->prepare("UPDATE apn_utilisateurs SET STATUS = 0 WHERE email = :email");
            } else if ($_POST['confirm'] == 2) {
                // Débannir l'utilisateur
                $query = $connection->prepare("UPDATE apn_utilisateurs SET STATUS = 1 WHERE email = :email");
            }

            $query->bindParam(':email', $email);
            $query->execute();

            // Rediriger vers la page appropriée selon le statut de l'utilisateur
            if ($_POST['confirm'] == 1) {
                // Utilisateur banni, redirection vers une page appropriée
                header('Location: user_admin.php');
            } else {
                // Utilisateur débanni, redirection vers la liste des utilisateurs
                header('Location: user_admin.php');
            }
            exit(); // Ajout de cette ligne pour arrêter l'exécution du script après la redirection
        } catch (PDOException $e) {
            echo "Erreur lors du bannissement de l'utilisateur : " . $e->getMessage();
            // Arrêter l'exécution du script ou effectuer une autre gestion d'erreur si nécessaire
        }
    }
}

// Vérifier le statut de l'utilisateur
if (isset($_SESSION['status']) && $_SESSION['status'] == 0) {
    // Utilisateur banni, redirection vers une page appropriée
    header('Location: user_ban.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bannir un utilisateur</title>
</head>
<body>
    <div class="container">
        <h1>Bannir un utilisateur</h1>
        <p>Êtes-vous sûr de vouloir bannir cet utilisateur <?= htmlspecialchars($email) ?> ? Vous pourrez le débannir.</p>

        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($email) ?>">
            <button type="submit" name="confirm" value="1">Bannir</button>
            <button type="submit" name="confirm" value="2">Débannir</button>
            <a href="user_admin.php">Annuler</a>
        </form>
    </div>
</body>
</html>
