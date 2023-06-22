<?php
// Démarrage de la session
session_start();

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // L'utilisateur n'est pas connecté, redirection vers la page de connexion
    header('Location: connexion.php');
}

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=livre', 'livre', '123456');

// Traitement du formulaire de modification du profil
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
    // Vérification que les deux mots de passe sont identiques
    if ($_POST['password'] === $_POST['password_confirm']) {
        // Hachage du mot de passe
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Mise à jour des données dans la base de données
        $query = $db->prepare('UPDATE utilisateurs SET login = :login, password = :password WHERE id = :id');
        $query->bindValue(':login', $_POST['login']);
        $query->bindValue(':password', $password);
        $query->bindValue(':id', $_SESSION['id']);
        $query->execute();

        // Mise à jour des données de session
        $_SESSION['login'] = $_POST['login'];

        // Redirection vers la page d'accueil
        header('Location: index.php');
    } else {
        // Les deux mots de passe ne sont pas identiques
        echo "Les deux mots de passe ne sont pas identiques.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modification du profil</title>
</head>
<body>
    <h1>Modification du profil</h1>

    <!-- Formulaire de modification du profil -->
    <form method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" value="<?= htmlspecialchars($_SESSION['login']) ?>" required>

        <label for="password">Nouveau mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirm">Confirmation du nouveau mot de passe:</label>
        <input type="password" id="password_confirm" name="password_confirm" required>

        <input type="submit" value="Modifier">
    </form>
</body>
</html>
