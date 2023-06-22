<?php
// Démarrage de la session
session_start();

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // L'utilisateur n'est pas connecté, redirection vers la page de connexion
    header('Location: connexion.php');
}

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=nom_de_votre_base_de_donnees', 'nom_utilisateur', 'mot_de_passe');

// Traitement du formulaire d'ajout de commentaire
if (isset($_POST['commentaire'])) {
    // Insertion du commentaire dans la base de données
    $query = $db->prepare('INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (:commentaire, :id_utilisateur, NOW())');
    $query->bindValue(':commentaire', $_POST['commentaire']);
    $query->bindValue(':id_utilisateur', $_SESSION['id']);
    $query->execute();

    // Redirection vers la page du livre d'or
    header('Location: livre-or.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajout d'un commentaire</title>
</head>
<body>
    <h1>Ajout d'un commentaire</h1>

    <!-- Formulaire d'ajout de commentaire -->
    <form method="post">
        <label for="commentaire">Commentaire:</label>
        <textarea id="commentaire" name="commentaire" required></textarea>

        <input type="submit" value="Ajouter">
    </form>
</body>
</html>
