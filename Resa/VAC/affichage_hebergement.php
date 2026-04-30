<?php
// --- Connexion BDD ---
session_start(); // 🔹 Pour savoir si l'utilisateur est connecté

$dsn = "mysql:host=localhost;dbname=RESA;charset=utf8mb4";
$user = "root"; 
$pass = ""; 

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Vérifie si un id est passé
if (!isset($_GET['id'])) {
    die("Aucun hébergement sélectionné.");
}

$id = (int) $_GET['id'];

// Récupération de l’hébergement
$sql = "SELECT h.*, t.NOMTYPEHEB 
        FROM HEBERGEMENT h
        JOIN TYPE_HEB t ON h.CODETYPEHEB = t.CODETYPEHEB
        WHERE h.NOHEB = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$heb = $stmt->fetch();

if (!$heb) {
    die("Hébergement introuvable.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($heb['NOMHEB']) ?> - Détails</title>
  <link rel="stylesheet" href="style.css">
  <style>
     * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: #f9f9f9;
      color: #333;
    }
    
    header {
      background: white;
      padding: 15px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 100;
      
    }

    header a {
      color: #ff385c;
      font-size: 15px;
      text-decoration: none;
    }

    nav a {
      margin-left: 20px;
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #ff385c;
    }

    .detail-container {
      max-width: 900px;
      margin: 50px auto;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .detail-container img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    .detail-info {
      padding: 20px;
    }

    .detail-info h2 {
      margin-bottom: 10px;
      color: #ff385c;
    }

    .detail-info p {
      margin: 8px 0;
    }
    
    .tarif {
      margin-top: 15px;
      font-size: 20px;
      font-weight: bold;
      color: #ff385c;
    }

    .btn-reserver {
      display: inline-block;
      margin-top: 25px;
      background: #ff385c;
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-reserver:hover {
      background: #e02f50;
    }

    .btn-login {
      display: inline-block;
      margin-top: 25px;
      background: #ccc;
      color: #333;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-login:hover {
      background: #bbb;
    }
  </style>
</head>
<body>

<header>
  <a href="vac.php"><h1>MyBnB</h1></a>
  <nav>
    <a href="ADM/dashboard.php">Accueil</a>
    <a href="#">Destinations</a>
    <a href="#">Mes réservations</a>
    <a href="logout.php">Déconnexion</a>
  </nav>
</header>

<div class="detail-container">
  <img src="<?= htmlspecialchars($heb['PHOTOHEB']) ?>" alt="<?= htmlspecialchars($heb['NOMHEB']) ?>">
  <div class="detail-info">
    <h2><?= htmlspecialchars($heb['NOMHEB']) ?></h2>
    <p><strong>Type :</strong> <?= htmlspecialchars($heb['NOMTYPEHEB']) ?></p>
    <p><strong>Places :</strong> <?= $heb['NBPLACEHEB'] ?></p>
    <p><strong>Surface :</strong> <?= $heb['SURFACEHEB'] ?> m²</p>
    <p><strong>Internet :</strong> <?= $heb['INTERNET'] ? 'Oui' : 'Non' ?></p>
    <p><strong>Année :</strong> <?= $heb['ANNEEHEB'] ?></p>
    <p><strong>Secteur :</strong> <?= htmlspecialchars($heb['SECTEURHEB']) ?></p>
    <p><strong>Orientation :</strong> <?= htmlspecialchars($heb['ORIENTATIONHEB']) ?></p>
    <p><strong>État :</strong> <?= htmlspecialchars($heb['ETATHEB']) ?></p>
    <p><?= htmlspecialchars($heb['DESCRIHEB']) ?></p>
    <p class="tarif">Tarif semaine : <?= number_format($heb['TARIFSEMHEB'], 2, ',', ' ') ?> €</p>

  <a href="reservation.php?noheb=<?= $heb['NOHEB'] ?>" class="btn-reserver">Réserver ce logement</a>


  </div>
</div>

</body>
</html>
