<?php

include "../template/header2.php";
require "../core/functions.php";

// Initialisation du tableau des logements par point d'arrêt avec quelques exemples
$logementsParArret = array(
    'Point A' => array(
        'Hôtel 1' => array('prix' => 100, 'promotion' => false),
        'Hôtel 2' => array('prix' => 150, 'promotion' => false),
        'Hôtel 3' => array('prix' => 120, 'promotion' => false)
    ),
    'Point B' => array(
        'Hôtel 4' => array('prix' => 200, 'promotion' => false),
        'Hôtel 5' => array('prix' => 180, 'promotion' => false)
    ),
    'Point C' => array(
        'Hôtel 6' => array('prix' => 130, 'promotion' => false)
    )
);

// Vérifier si le formulaire a été soumis
if (isset($_POST['ajouterPromotion'])) {
    $pointArret = $_POST['pointArret'];
    $logement = $_POST['logement'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $reduction = $_POST['reduction'];

    // Appliquer la promotion au logement et à la période spécifiés
    if (isset($logementsParArret[$pointArret][$logement])) {
        $logementsParArret[$pointArret][$logement]['promotion'] = array(
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'reduction' => $reduction
        );
    }
}

// Fonction pour vérifier si une date est comprise entre deux autres dates
function estDansPeriode($date, $dateDebut, $dateFin) {
    return ($date >= $dateDebut && $date <= $dateFin);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Offres Promotionnelles pour Logements</title>
</head>
<body>
    <h2>Ajouter une Offre Promotionnelle</h2>
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
        <label for="dateDebut">Date de Début de la Promotion :</label>
        <input type="date" name="dateDebut"><br>
        <label for="dateFin">Date de Fin de la Promotion :</label>
        <input type="date" name="dateFin"><br>
        <label for="reduction">Réduction en % :</label>
        <input type="number" name="reduction" min="0" max="100"><br>
        <input type="submit" name="ajouterPromotion" value="Ajouter Promotion">
    </form>

    <h2>Logements avec Offres Promotionnelles</h2>
    <ul>
        <?php
        foreach ($logementsParArret as $pointArret => $logements) {
            echo "<li><strong>$pointArret:</strong></li>";
            foreach ($logements as $logement => $details) {
                echo "<li>$logement - Prix: {$details['prix']}";
                if ($details['promotion']) {
                    echo " (Promotion: {$details['promotion']['reduction']}% de réduction)";
                }
                echo "</li>";
            }
        }
        ?>
    </ul>

    <h2>Vérification des Offres Promotionnelles</h2>
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
        <label for="dateVerification">Date à Vérifier :</label>
        <input type="date" name="dateVerification"><br>
        <input type="submit" name="verifierPromotion" value="Vérifier Promotion">
    </form>

    <?php
    if (isset($_POST['verifierPromotion'])) {
        $pointArret = $_POST['pointArret'];
        $logement = $_POST['logement'];
        $dateVerification = $_POST['dateVerification'];

        if (isset($logementsParArret[$pointArret][$logement])) {
            $details = $logementsParArret[$pointArret][$logement];
            if ($details['promotion'] && estDansPeriode($dateVerification, $details['promotion']['dateDebut'], $details['promotion']['dateFin'])) {
                $prixApresPromotion = $details['prix'] * (1 - $details['promotion']['reduction'] / 100);
                echo "<p>Le logement $logement à $pointArret bénéficie d'une promotion de {$details['promotion']['reduction']}% jusqu'au {$details['promotion']['dateFin']}. Prix après promotion: $prixApresPromotion.</p>";
            } else {
                echo "<p>Le logement $logement à $pointArret ne bénéficie pas d'une promotion à la date spécifiée.</p>";
            }
        }
    }
    ?>
</body>
</html>
