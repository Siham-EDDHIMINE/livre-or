<?php
// Démarrage de la session
session_start();

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
</head>
<body>
    <h1>Bienvenue sur notre livre d'or!</h1>

    <!-- Ajout d'un lien vers la page d'ajout de commentaire (uniquement si l'utilisateur est connecté) -->
    <?php if (isset($_SESSION['id'])): ?>
        <a href="commentaire.php">Ajouter un commentaire</a>
    <?php endif; ?>

    <h2>Commentaires:</h2>
    <?php foreach ($comments as $comment): ?>
        <p>Posté le <?= date('d/m/Y', strtotime($comment['date'])) ?> par <?= htmlspecialchars($comment['login']) ?>:</p>
        <p><?= nl2br(htmlspecialchars($comment['commentaire'])) ?></p>
    <?php endforeach; ?>
</body>
</html>
