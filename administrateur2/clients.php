<?php
include "../template/header2.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Gestion des clients</title>
  <style>
    /* Ajoutez ici votre CSS pour personnaliser la page */
  </style>
</head>
<body>
  <h1>Gestion des clients</h1>

  <h2>Ajouter un client</h2>
  <form action="ajouter_client.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required><br><br>
    
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="telephone">Téléphone :</label>
    <input type="tel" id="telephone" name="telephone"><br><br>
    
    <input type="submit" value="Ajouter">
  </form>

  <h2>Liste des clients</h2>
  <table>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Téléphone</th>
    </tr>
    <?php
      // Code PHP pour récupérer et afficher dynamiquement les clients depuis une base de données
      // Remplacez les lignes suivantes par votre propre logique de récupération des clients

      // Exemple de code statique pour afficher deux clients fictifs
      $clients = array(
        array("John Doe", "john@example.com", "123-456-7890"),
        array("Jane Smith", "jane@example.com", "987-654-3210")
      );

      foreach ($clients as $client) {
        echo "<tr>";
        echo "<td>".$client[0]."</td>";
        echo "<td>".$client[1]."</td>";
        echo "<td>".$client[2]."</td>";
        echo "</tr>";
      }
    ?>
  </table>

  <h2>Modifier un client</h2>
  <form action="modifier_client.php" method="POST">
    <label for="nomModif">Nom :</label>
    <input type="text" id="nomModif" name="nomModif" required><br><br>
    
    <label for="emailModif">Email :</label>
    <input type="email" id="emailModif" name="emailModif" required><br><br>
    
    <label for="telephoneModif">Téléphone :</label>
    <input type="tel" id="telephoneModif" name="telephoneModif"><br><br>
    
    <input type="submit" value="Modifier">
  </form>

  <h2>Supprimer un client</h2>
  <form action="supprimer_client.php" method="POST">
    <label for="idSuppr">ID du client :</label>
    <input type="number" id="idSuppr" name="idSuppr" required><br><br>
    
    <input type="submit" value="Supprimer">
  </form>
</body>
</html>
