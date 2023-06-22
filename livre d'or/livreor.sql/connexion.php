<?php
// Démarrage de la session
session_start();

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=livre', 'livre', '123456');

// Traitement du formulaire de connexion
if (isset($_POST['login']) && isset($_POST['password'])) {
    // Récupération de l'utilisateur depuis la base de données
    $query = $db->prepare('SELECT * FROM utilisateurs WHERE login = :login');
    $query->bindValue(':login', $_POST['login']);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($_POST['password'], $user['password'])) {
        // L'utilisateur est connecté
        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];

        // Redirection vers la page d'accueil
        header('Location: profil.php');
    } else {
        // L'utilisateur n'est pas connecté
        echo "Login ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <!-- Formulaire de connexion -->
    <form method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
