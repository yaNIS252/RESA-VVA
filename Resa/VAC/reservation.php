<?php
session_start();

// --- Connexion directe à la base ---
$dsn = "mysql:host=localhost;dbname=RESA;charset=utf8mb4";
$user = "root";
$pass = "";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

// --- Vérifie si l'utilisateur est connecté ---
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// --- Vérifie si un logement a été sélectionné ---
if (!isset($_GET['id'])) {
    die("Aucun logement sélectionné.");
}

$noheb = (int) $_GET['id'];   // ID du logement
$user_id = $_SESSION['user_id']; // ID utilisateur connecté

// --- Traitement du formulaire ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datedebsem = $_POST['datedebsem'];
    $nb_occupant = (int) $_POST['nb_occupant'];

    try {
        // Vérifier si la semaine existe déjà
        $checkWeek = $pdo->prepare("SELECT DATEDEBSEM FROM semaine WHERE DATEDEBSEM = ?");
        $checkWeek->execute([$datedebsem]);

        if ($checkWeek->rowCount() == 0) {
            // Crée la semaine si elle n'existe pas encore
            $insertWeek = $pdo->prepare("INSERT INTO semaine (DATEDEBSEM) VALUES (?)");
            $insertWeek->execute([$datedebsem]);
        }

        // Insertion de la réservation
        $stmt = $pdo->prepare("
            INSERT INTO resa (USER, DATEDEBSEM, NOHEB, CODEETATRESA, DATERESEA, NB_OCCUPANT)
            VALUES (:user, :datedebsem, :noheb, :etat, NOW(), :nb_occupant)
        ");
        $stmt->execute([
            ':user' => $user_id,
            ':datedebsem' => $datedebsem,
            ':noheb' => $noheb,
            ':etat' => 1, // Par défaut : "En attente"
            ':nb_occupant' => $nb_occupant
        ]);

        $success = "✅ Réservation enregistrée avec succès !";

    } catch (PDOException $e) {
        $error = "Erreur lors de l’enregistrement : " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation du logement</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #ff385c;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 500;
            text-align: left;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #ff385c;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover { background: #e03050; }
        .success, .error {
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Réserver ce logement</h2>

    <?php if (!empty($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php elseif (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <label for="datedebsem">Date de début de semaine :</label>
    <input type="date" name="datedebsem" id="datedebsem" required>

    <label for="nb_occupant">Nombre d'occupants :</label>
    <input type="number" name="nb_occupant" id="nb_occupant" min="1" max="10" required>

    <button type="submit">Confirmer la réservation</button>

    <p style="margin-top:15px;"><a href="logement.php?id=<?= $noheb ?>">← Retour au logement</a></p>
</form>

</body>
</html>
