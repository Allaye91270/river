<?php
include "../template/header2.php";
require "../core/functions.php";
// Plages tarifaires spécifiques (exemple)
$tarifs = array(
    "2023-07-01" => 100,
    "2023-07-15" => 120,
    "2023-07-29" => 150,
    // ... Ajoutez d'autres plages tarifaires ici ...
);

// Fonction pour obtenir le tarif en fonction de la date
function getTarif($date) {
    global $tarifs;

    foreach ($tarifs as $plage => $tarif) {
        if ($date >= $plage) {
            return $tarif;
        }
    }

    // Si aucune plage n'a été trouvée, retourner le tarif par défaut
    return 80; // Tarif par défaut
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nouvellePlage = $_POST["nouvelle_plage"];
    $nouveauTarif = $_POST["nouveau_tarif"];

    $tarifs[$nouvellePlage] = $nouveauTarif;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Plages Tarifaires</title>
</head>
<body>
    <h1>Gestion des Plages Tarifaires</h1>

    <h2>Ajouter une Nouvelle Plage Tarifaire</h2>
    <form method="post">
        <label for="nouvelle_plage">Date de la nouvelle plage :</label>
        <input type="date" id="nouvelle_plage" name="nouvelle_plage" required><br>
        <label for="nouveau_tarif">Nouveau tarif :</label>
        <input type="number" id="nouveau_tarif" name="nouveau_tarif" required><br>
        <button type="submit">Ajouter Plage Tarifaire</button>
    </form>

    <h2>Liste des Plages Tarifaires</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Tarif</th>
        </tr>
        <?php foreach ($tarifs as $plage => $tarif) : ?>
        <tr>
            <td><?php echo $plage; ?></td>
            <td><?php echo $tarif; ?> €</td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
