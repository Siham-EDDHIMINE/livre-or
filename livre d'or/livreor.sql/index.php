<?php
// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=livre', 'livre', '123456');

// Récupération des commentaires depuis la base de données
$query = $db->prepare('SELECT commentaires.commentaire, commentaires.date, utilisateurs.login FROM commentaires INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id ORDER BY commentaires.date DESC');
$query->execute();
$comments = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Livre d'or</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Bienvenue sur notre livre d'or!</h1>

    <!-- Ajout d'un lien vers la page d'inscription -->
    <a href="inscription.php">Inscription</a>

    <!-- Ajout d'un lien vers la page de connexion -->
    <a href="connexion.php">Connexion</a>

    <!-- Ajout d'un bouton pour ajouter un commentaire (uniquement si l'utilisateur est connecté) -->
    <?php if (isset($_SESSION['id'])): ?>
        <a href="commentaire.php"><button>Ajouter un commentaire</button></a>
    <?php endif; ?>

    <!-- Ajout d'une image -->
    <img src="image.jpg" alt="Image">

    <h2>Commentaires:</h2>
    <?php foreach ($comments as $comment): ?>
        <p>Posté le <?= date('d/m/Y', strtotime($comment['date'])) ?> par <?= htmlspecialchars($comment['login']) ?>:</p>
        <p><?= nl2br(htmlspecialchars($comment['commentaire'])) ?></p>
    <?php endforeach; ?>
</body>
</html>
