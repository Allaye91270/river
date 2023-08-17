<?php
include "../template/header2.php";
require "../core/functions.php";
session_start();

$connection = connectDB(); // Utilisez la fonction connectdb() pour obtenir la connexion PDO

if (!$connection) {
    // Gérer l'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données");
}

$query = $connection->query("SELECT * FROM apn_utilisateurs");
$utilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<button type="submit" class="btn btn-danger">Déconnexion</button>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des utilisateurs</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Date de naissance</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?= $utilisateur['id'] ?></td>
                    <td><?= $utilisateur['FIRSTNAME'] ?></td>
                    <td><?= $utilisateur['LASTNAME'] ?></td>
                    <td><?= $utilisateur['BIRTHDAY'] ?></td>
                    <td><?= $utilisateur['EMAIL'] ?></td>
                    <td><?= $utilisateur['ROLE'] ?></td>
                    <td><?= $utilisateur['STATUS'] ?></td>
                    <td>
                        <form method="post" action="update_role.php">
                            <input type="hidden" name="user_id" value="<?= $utilisateur['id'] ?>">
                            <select name="role">
                                <option value="admin" <?php if ($utilisateur['ROLE'] === 'admin') echo 'selected'; ?>>Administrateur</option>
                                <option value="client" <?php if ($utilisateur['ROLE'] === 'client') echo 'selected'; ?>>Client</option>
                            </select>
                            <button type="submit">Enregistrer</button>
                        </form>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="ban_user.php?id=<?= $utilisateur['EMAIL'] ?>">Bannir</a>
                        <a class="btn btn-primary" href="../back2\del_user.php?id=<?= $utilisateur['EMAIL'] ?>">Supprimer</a>
                        <a class="btn btn-primary" href="modif_user.php?id=<?= $utilisateur['EMAIL'] ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h1>Barre de recherche AJAX</h1>

    <input type="text" id="search" placeholder="Rechercher...">
    <button onclick="search()">Rechercher</button>
    <div id="results"></div>

    <script>
        function search() {
            var keyword = document.getElementById("search").value; // Récupérer le mot-clé saisi par l'utilisateur

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById("results").innerHTML = xhr.responseText; // Afficher les résultats de recherche dans la zone de résultats
                    }
                }
            };
            
            xhr.open("POST", "search.php", true); // Fichier PHP qui effectue la recherche
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("keyword=" + keyword); // Envoyer le mot-clé au serveur
        }
    </script>

    <form action="../index.php" method="post">
        
    </form>
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
$connection = null;
?>
