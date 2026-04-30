
<?php
// Si l'utilisateur est déjà connecté, on le redirige
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username_db = "root"; 
    $password_db = ""; 
    $dbname = "resa"; 

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username_db, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération du formulaire
        $user = $_POST['user'];
        $password = $_POST['password'];

        // Requête SQL (on récupère aussi TYPECOMPTE)
        $stmt = $conn->prepare("SELECT USER, MDP, TYPECOMPTE FROM compte WHERE USER = :user");
        $stmt->bindParam(':user', $user);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe (ici en clair → à sécuriser plus tard)
            if ($password === $userData['MDP']) {
                
                // Stockage en session
                $_SESSION['user'] = $userData['USER'];
                $_SESSION['type'] = $userData['TYPECOMPTE'];

                // Redirection selon TYPECOMPTE
                if ($userData['TYPECOMPTE'] === 'ADM') {

                    header("Location: ADM/dashboard.php");

                } elseif ($userData['TYPECOMPTE'] === 'VAC') {

                    header("Location: VAC/vac.php");
                } else {
                    header("Location: page1.php"); // par défaut
                }
                exit();
            } else {
                $error = " Nom d'utilisateur ou Mot de passe incorrect.";
            }
        }
    } catch (PDOException $e) {
        $error = "Erreur de connexion à la base : " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Page de connexion</title>
</head>
<body>

    <div class="login-container">
        <h2>Connexion</h2>

        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
    

    <form method="post" action="">
        <label for="user">Nom d'utilisateur :</label><br>
        <input type="text" id="user" name="user" required><br><br>
        
        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Se connecter">
    </form>
    </div>
</body>
</html>
