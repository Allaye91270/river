<?php
include "../template/header2.php";
require "../core/functions.php";
// Initialisation du tableau des logements par point d'arrêt avec quelques exemples
$logementsParArret = array(
    'Point A' => array('Hôtel 1', 'Hôtel 2', 'Hôtel 3'),
    'Point B' => array('Hôtel 4', 'Hôtel 5'),
    'Point C' => array('Hôtel 6')
);

// Vérifier si le formulaire a été soumis
if (isset($_POST['modifierLogement'])) {
    $pointArret = $_POST['pointArret'];
    $logementIndex = $_POST['logementIndex'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];

    // Effectuer la modification (ici, nous utilisons une simple sortie pour illustrer)
    echo "Le logement '{$logementsParArret[$pointArret][$logementIndex]}' sera fermé pour rénovation du $dateDebut au $dateFin.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Logement (Fermeture pour Rénovation)</title>
</head>
<body>
    <h2>Modifier un Logement (Fermeture pour Rénovation)</h2>
    <form method="post">
        <label for="pointArret">Point d'Arrêt :</label>
        <select name="pointArret">
            <?php
            foreach ($logementsParArret as $pointArret => $logements) {
                echo "<option value='$pointArret'>$pointArret</option>";
            }
            ?>
        </select><br>
        <label for="logementIndex">Logement à Modifier :</label>
        <select name="logementIndex">
            <?php
            foreach ($logementsParArret as $pointArret => $logements) {
                foreach ($logements as $index => $logement) {
                    echo "<option value='$index'>$logement ($pointArret)</option>";
                }
            }
            ?>
        </select><br>
        <label for="dateDebut">Date de Début de Fermeture :</label>
        <input type="date" name="dateDebut"><br>
        <label for="dateFin">Date de Fin de Fermeture :</label>
        <input type="date" name="dateFin"><br>
        <input type="submit" name="modifierLogement" value="Modifier">
    </form>
</body>
</html>
