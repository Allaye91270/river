<?php
include "../template/header2.php";
require "../core/functions.php";
// Initialisation du tableau des logements par point d'arrêt avec quelques exemples
$logementsParArret = array(
    'Point A' => array(
        'Hôtel 1' => array('prix' => 100),
        'Hôtel 2' => array('prix' => 150),
        'Hôtel 3' => array('prix' => 120)
    ),
    'Point B' => array(
        'Hôtel 4' => array('prix' => 200),
        'Hôtel 5' => array('prix' => 180)
    ),
    'Point C' => array(
        'Hôtel 6' => array('prix' => 130)
    )
);

// Plages tarifaires spécifiques pour certaines semaines
$plagesTarifaires = array(
    'été' => array('2023-07-01' => '2023-08-31', 'coeff' => 1.2) // Augmentation de 20% pendant l'été
);

// Vérifier si le formulaire a été soumis
if (isset($_POST['calculerPrix'])) {
    $pointArret = $_POST['pointArret'];
    $logement = $_POST['logement'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];

    // Calculer le prix en tenant compte des plages tarifaires spécifiques
    $prixTotal = calculerPrixTotal($pointArret, $logement, $dateDebut, $dateFin);

    // Afficher le résultat
    echo "Le prix total pour le logement '$logement' à '$pointArret' du $dateDebut au $dateFin est de $prixTotal euros.";
}

// Fonction pour calculer le prix total en tenant compte des plages tarifaires spécifiques
function calculerPrixTotal($pointArret, $logement, $dateDebut, $dateFin) {
    global $logementsParArret, $plagesTarifaires;

    $prixTotal = 0;

    if (isset($logementsParArret[$pointArret][$logement])) {
        $prixBase = $logementsParArret[$pointArret][$logement]['prix'];
        
        $currentDate = new DateTime($dateDebut);
        $endDate = new DateTime($dateFin);

        while ($currentDate <= $endDate) {
            foreach ($plagesTarifaires as $plage => $details) {
                if (estDansPeriode($currentDate->format('Y-m-d'), $details[0], $details[1])) {
                    $prixTotal += $prixBase * $details['coeff'];
                }
            }
            $currentDate->add(new DateInterval('P1D')); // Ajouter 1 jour
        }
    }

    return $prixTotal;
}

// Fonction pour vérifier si une date est comprise entre deux autres dates
function estDansPeriode($date, $dateDebut, $dateFin) {
    return ($date >= $dateDebut && $date <= $dateFin);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gérer des Plages Tarifaires Spécifiques</title>
</head>
<body>
    <h2>Calculer le Prix Total avec Plages Tarifaires Spécifiques</h2>
    <form method="post">
        <label for="pointArret">Point d'Arrêt :</label>
        <select name="pointArret">
            <?php
            foreach ($logementsParArret as $pointArret => $logements) {
                echo "<option value='$pointArret'>$pointArret</option>";
            }
            ?>
        </select><br>
        <label for="logement">Logement :</label>
        <select name="logement">
            <?php
            foreach ($logementsParArret as $pointArret => $logements) {
                foreach ($logements as $logement => $details) {
                    echo "<option value='$logement'>$logement ($pointArret)</option>";
                }
            }
            ?>
        </select><br>
        <label for="dateDebut">Date de Début :</label>
        <input type="date" name="dateDebut"><br>
        <label for="dateFin">Date de Fin :</label>
        <input type="date" name="dateFin"><br>
        <input type="submit" name="calculerPrix" value="Calculer Prix">
    </form>
</body>
</html>
