<?php
session_start();
require "core/functions.php";
include "template/header.php";

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
        $email = cleanEmail($_POST['email']);
        $pwd = $_POST['pwd'];

        $connect = connectDB();
        $queryPrepared = $connect->prepare("SELECT pwd, role FROM apn_utilisateurs WHERE email=:email");
        $queryPrepared->execute(["email" => $email]);

        $result = $queryPrepared->fetch();

        if (!empty($result) && password_verify($pwd, $result["pwd"])) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $result["role"];
            $_SESSION['login'] = 1;

            if ($result["role"] === "admin") {
                header("Location: administrateur/user_admin.php");
                exit(); // Terminer le script après la redirection
            } elseif ($result["role"] === "client") {
                header("Location: compte.php");
                exit(); // Terminer le script après la redirection
            }
        } else {
            echo "Identifiants incorrects";
        }
    }
    
header("Location: compte.php");
exit();

}

?>
<br><br><br><br>
<div class="container1">
    <h2>Connexion</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Adresse e-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="pwd">Mot de passe:</label>
            <input type="password" id="pwd" name="pwd" required>
        </div><br>
        <div class="form-group">
            <input type="submit" value="Se connecter">
        </div>
    </form>
    <br>
    <a href="register.php">Vous n'avez pas de compte ?</a>
</div>

<br><br>
<?php include "template/footer.php" ?>