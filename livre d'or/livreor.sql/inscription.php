<?php
// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=livre', 'livre', '123456');

// Traitement du formulaire d'inscription
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
    // Vérification que les deux mots de passe sont identiques
    if ($_POST['password'] === $_POST['password_confirm']) {
        // Hachage du mot de passe
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insertion des données dans la base de données
        $query = $db->prepare('INSERT INTO utilisateurs (login, password) VALUES (:login, :password)');
        $query->bindValue(':login', $_POST['login']);
        $query->bindValue(':password', $password);
        $query->execute();

        // Redirection vers la page de connexion
        header('Location: connexion.php');
    } else {
        // Les deux mots de passe ne sont pas identiques
        echo "Les deux mots de passe ne sont pas identiques.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <!-- Formulaire d'inscription -->
    <form method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirm">Confirmation du mot de passe:</label>
        <input type="password" id="password_confirm" name="password_confirm" required>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
