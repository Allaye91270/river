<?php
$dsn = "mysql:host=193.70.42.147;dbname=PA;port=3306";
$username = "palacio";
$password = "palacio";

try {
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];

    $query = $connection->prepare("SELECT * FROM apn_utilisateurs WHERE FIRSTNAME LIKE :keyword OR LASTNAME LIKE :keyword OR EMAIL LIKE :keyword");
    $query->bindValue(':keyword', '%' . $keyword . '%');
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $result) {
            echo '<p>ID: ' . $result['id'] . '</p>';
            echo '<p>Prénom: ' . $result['FIRSTNAME'] . '</p>';
            echo '<p>Nom: ' . $result['LASTNAME'] . '</p>';
            echo '<p>Date de naissance: ' . $result['BIRTHDAY'] . '</p>';
            echo '<p>Email: ' . $result['EMAIL'] . '</p>';
            echo '<p>Rôle: ' . $result['ROLE'] . '</p>';
            echo '<p>Statut: ' . $result['STATUS'] . '</p>';
        }
    } else {
        echo 'Aucun résultat trouvé.';
    }

    $query = $connection->prepare("SELECT * FROM apn_abonnes WHERE id LIKE :keyword OR email LIKE :keyword OR dateInscription LIKE :keyword OR statutAbonnement LIKE :keyword");
    $query->bindValue(':keyword', '%' . $keyword . '%');
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $result) {
            echo '<p>ID: ' . $result['id'] . '</p>';
            echo '<p>Email: ' . $result['email'] . '</p>';
            echo '<p>Date d\'inscription: ' . $result['dateInscription'] . '</p>';
            echo '<p>Statut d\'abonnement: ' . $result['statutAbonnement'] . '</p>';
        }
    } else {
        echo 'Aucun résultat trouvé.';
    }

    $query = $connection->prepare("SELECT * FROM apn_acompte WHERE id LIKE :keyword OR IDRESERVATION LIKE :keyword OR lastname LIKE :keyword OR firstname LIKE :keyword OR montantAcompte LIKE :keyword");
    $query->bindValue(':keyword', '%' . $keyword . '%');
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $result) {
            echo '<p>ID: ' . $result['id'] . '</p>';
            echo '<p>ID Réservation: ' . $result['IDRESERVATION'] . '</p>';
            echo '<p>Nom: ' . $result['lastname'] . '</p>';
            echo '<p>Prénom: ' . $result['firstname'] . '</p>';
            echo '<p>Montant: ' . $result['montantAcompte'] . '</p>';
        }
    } else {
        echo 'Aucun résultat trouvé.';
    }

    $query = $connection->prepare("SELECT * FROM apn_avis WHERE nom LIKE :keyword OR avis LIKE :keyword OR note LIKE :keyword OR date LIKE :keyword");
    $query->bindValue(':keyword', '%' . $keyword . '%');
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $result) {
            echo '<p>nom: ' . $result['nom'] . '</p>';
            echo '<p>Description: ' . $result['avis'] . '</p>';
            echo '<p>Note: ' . $result['note'] . '</p>';
            echo '<p>Date: ' . $result['date'] . '</p>';
        }
    } else {
        echo 'Aucun résultat trouvé.';
    }

    $query = $connection->prepare("SELECT * FROM apn_devis WHERE id LIKE :keyword OR lastname LIKE :keyword OR firstname  LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword OR date LIKE :keyword OR number_guest LIKE :keyword");
    $query->bindValue(':keyword', '%' . $keyword . '%');
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $result) {
            echo '<p>ID: ' . $result['id'] . '</p>';
            echo '<p>Nom: ' . $result['lastname'] . '</p>';
            echo '<p>Prénom: ' . $result['firstname'] . '</p>';
            echo '<p>Email: ' . $result['email'] . '</p>';
            echo '<p>Téléphone: ' . $result['phone'] . '</p>';
            echo '<p>Date: ' . $result['date'] . '</p>';
            echo '<p>Nombre d\'invités: ' . $result['number_guest'] . '</p>';
        }
    } else {
        echo 'Aucun résultat trouvé.';
    }
    
    $query = $connection->prepare("SELECT * FROM apn_evenements WHERE IDEVENEMENT LIKE :keyword OR IDSALLE LIKE :keyword OR TITRE LIKE :keyword OR DESCRIPTION LIKE :keyword OR DATE LIKE :keyword OR HEURE LIKE :keyword");
    $query->bindValue(':keyword', '%' . $keyword . '%');
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if ($results) {
        foreach ($results as $result) {
            echo '<p>ID: ' . $result['IDEVENEMENT'] . '</p>';
            echo '<p>Salle: ' . $result['IDSALLE'] . '</p>';
            echo '<p>Titre: ' . $result['TITRE'] . '</p>';
            echo '<p>Description: ' . $result['DESCRIPTION'] . '</p>';
            echo '<p>Date: ' . $result['DATE'] . '</p>';
            echo '<p>Heure: ' . $result['HEURE'] . '</p>';
        }
    } else {
        echo 'Aucun résultat trouvé.';
    }
    
    $query = $connection->prepare("SELECT * FROM apn_prestataire WHERE IDPRESTATAIRE LIKE :keyword OR NOM LIKE :keyword");
    $query->bindValue(':keyword', '%' . $keyword . '%');
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if ($results) {
        foreach ($results as $result) {
            echo '<p>ID: ' . $result['IDPRESTATAIRE'] . '</p>';
            echo '<p>Nom: ' . $result['NOM'] . '</p>';
           
        }
    } else {
        echo 'Aucun résultat trouvé.';
    }
}
    

$connection = null;
?>
