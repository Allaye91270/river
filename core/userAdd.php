<?php
session_start();

require "functions.php";

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// require '../newsletter/PHPMailer/src/Exception.php';
// require '../newsletter/PHPMailer/src/PHPMailer.php';
// require '../newsletter/PHPMailer/src/SMTP.php';

connectDB();

if (
    count($_POST) != 9 ||
    !isset($_POST["gender"]) ||
    empty($_POST["firstname"]) ||
    empty($_POST["lastname"]) ||
    empty($_POST["email"]) ||
    empty($_POST["pwd"]) ||
    empty($_POST["pwdConfirm"]) ||
    empty($_POST["birthday"]) ||
    empty($_POST["country"]) ||
    empty($_POST["cgu"])
) {
    die("Tentative de HACK !!!");
}

//Nettoyage des données
//->Firstname, Lastname, Email
$gender = $_POST["gender"];
$firstname = cleanFirstname($_POST["firstname"]);
$lastname = cleanLastname($_POST['lastname']);
$email = cleanEmail($_POST['email']);
$country = $_POST["country"];
$birthday = $_POST["birthday"];
$pwd = $_POST["pwd"];
$pwdConfirm = $_POST["pwdConfirm"];

$listOfErrors = [];
//Vérification des données    
//Gender -> 0, 1 ou 2
$listOfGenders = [0, 1, 2];
if (!in_array($gender, $listOfGenders)) {
    $listOfErrors[] = "Ce genre n'existe pas";
}
//Firstname -> Min 2 caractères
if (strlen($firstname) < 2) {
    $listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
}
//Lastname -> Min 2 caractères
if (strlen($lastname) < 2) {
    $listOfErrors[] = "Le nom doit faire plus de 2 caractères";
}

//Email -> Bon format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $listOfErrors[] = "L'email est incorrect";
} else {
    //Unicité de l'email
    $connection = connectDB();
    //Donne moi l'utilisateur dans la table apn_utilisateurs qui a pour email $email
    $queryPrepared = $connection->prepare("SELECT id FROM apn_utilisateurs WHERE email=:email");
    $queryPrepared->execute(["email" => $email]);
    $result = $queryPrepared->fetch();
    if (!empty($result)) {
        $listOfErrors[] = "L'email est déjà utilisé";
    }
}

//Country -> fr ou pl
$listOfCountries = ['fr', 'pl'];
if (!in_array($country, $listOfCountries)) {
    $listOfErrors[] = "Ce pays n'existe pas";
}

//pwd -> 8 caractères avec minuscules, majuscules et chiffres
if (
    strlen($pwd) < 8 || 
    !preg_match("#[a-z]#", $pwd) ||
    !preg_match("#[A-Z]#", $pwd) ||
    !preg_match("#[0-9]#", $pwd)
) {
    $listOfErrors[] = "Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules et des chiffres.";
}

//pwdConfirm -> = pwd
if ($_POST["pwdConfirm"] != $_POST['pwd']) {
    $listOfErrors[] = "Mot de passe de confirmation incorrect";
}

//Birthday -> entre 13 et 90
//la date est valide ? 1986-11-29
$dateExploded = explode("-", $_POST["birthday"]);
if (!checkdate($dateExploded[1], $dateExploded[2], $dateExploded[0])) {
    $listOfErrors[] = "Date de naissance incorrecte";
} else {
    $birthSecond = strtotime($_POST["birthday"]);
    $age = (time() - $birthSecond) / 3600 / 24 / 365.25;
    if ($age < 13 || $age > 90) {
        $listOfErrors[] = "Vous devez avoir entre 13 et 90 ans";
    }
}

if (empty($listOfErrors)) {
    //SI OK

    $dsn = "mysql:host=193.70.42.147;dbname=RIVER;port=3306";
    $username = "RIVER";
    $password = "RIVER";

    try {
        $connection = new PDO($dsn, $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $_SESSION["errors"] = "Erreur de connexion à la base de données : " . $e->getMessage();
        header("Location: ../error.php");
        exit();
    }

    // Requête SQL pour insérer un nouvel utilisateur
    $queryPrepared = $connection->prepare("INSERT INTO apn_utilisateurs 
            (firstname, lastname, email, gender, country, birthday, pwd) 
            VALUES (:firstname, :lastname, :email, :gender, :country, :birthday, :pwd)");

    //Executer cette requete
    $queryPrepared->execute([
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email,
        "gender" => $gender,
        "country" => $country,
        "birthday" => $birthday,
        "pwd" => password_hash($pwd, PASSWORD_DEFAULT),
    ]);

    // $mail = new PHPMailer();
    // $mail->isSMTP();
    // $mail->Host = 'smtp.gmail.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'lepalacio91@gmail.com';
    // $mail->Password = 'cugydziqedlhfzon';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = 587;
    // $mail->setFrom('lepalacio91@gmail.com', 'Le Palacio');
    // $mail->addAddress($email, $firstname . ' ' . $lastname);
    // $mail->isHTML(true);
    // $mail->Subject = 'Bienvenue au Palacio';
    // $mail->Body = htmlspecialchars($firstname) . ',<br>Bienvenue sur notre site, vous êtes bien inscrit sur le site du Palacio';
    // // $mail->AltBody = 'Dear ' . $firstname . ', Welcome to our website. Thank you for registering.';

    // $mail->send();

    //Redirection sur la page de login
    header("Location: ../login.php");
    exit();
} else {
    //SI NOK
    // --> Redirection sur le register avec les messages d'erreurs
    $_SESSION["errors"] = $listOfErrors;
    header("Location: ../register.php");
    exit();
}
?>
