<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Réservations</title>
  <style>
    /* Reset simple */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", sans-serif; }
    body { background: #f9f9f9; color: #333; }

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

    header a {color: #ff385c;font-size: 15px;text-decoration: none;}
    nav a {margin-left: 20px;text-decoration: none;color: #333;font-weight: 500;transition: color 0.3s;}
    nav a:hover {color: #ff385c;}

    /* Hero section */
    .hero {
      background: url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
      height: 80vh; display: flex; align-items: center; justify-content: center; color: white; text-align: center; position: relative;
    }
    .hero::after { content: ""; position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.4); }
    .hero-content { position: relative; z-index: 1; }
    .hero h2 { font-size: 48px; margin-bottom: 15px; }
    .search-bar { background: white; border-radius: 50px; display: flex; align-items: center; padding: 10px; width: 80%; max-width: 800px; margin: 20px auto 0; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .search-bar input { flex: 1; border: none; outline: none; padding: 10px 15px; border-radius: 50px; font-size: 16px; }
    .search-bar button { background: #ff385c; color: white; border: none; padding: 12px 20px; border-radius: 50px; cursor: pointer; font-weight: bold; transition: background 0.3s; }
    .search-bar button:hover { background: #e6294b; }

    /* Section logements */
    .section { padding: 50px; max-width: 1200px; margin: auto; }
    .section h3 { font-size: 28px; margin-bottom: 25px; color: #222; }

    /* wrapper de cards (important) */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      text-decoration: none;   /* retire le soulignement du lien */
      color: inherit;          /* garde la couleur du texte */
      display: block;          /* important : rend l'<a> en block pour que la card prenne toute la place */
    }
    .card:hover { transform: translateY(-5px); }
    .card img { width: 100%; height: 180px; object-fit: cover; display: block; }
    .card .info { padding: 15px; }
    .card h4 { font-size: 18px; margin-bottom: 5px; }
    .card p { font-size: 14px; color: #666; }
    .card span { display: block; margin-top: 10px; font-weight: bold; color: #ff385c; }

    footer { background: #333; color: white; text-align: center; padding: 20px; margin-top: 50px; }
  </style>
</head>
<body>

<header>
  <a href="dashboard.php"><h1>MyBnB</h1></a>
  <nav>
    <a href="#">Accueil</a>
    <a href="#">Destinations</a>
    <a href="#">Mes réservations</a>
    <a href="logout.php">Déconnexion</a>
  </nav>
</header>

<section class="hero">
  <div class="hero-content">
    <h2>Voyagez comme chez vous</h2>
    <p>Trouvez des logements uniques et des expériences locales.</p>
    <div class="search-bar">
      <input type="text" placeholder="Où allez-vous ?">
      <button>Rechercher</button>
    </div>
  </div>
</section>

<section class="section">
  <h3>Logements populaires</h3>

  <!-- <-- IMPORTANT : wrapper .cards --> 
  <div class="cards">

    <!-- Utilise ../ si affiche_hebergement.php est à la racine (Resa/) et dashboard est dans ADM/ -->
    <a href="../affichage_hebergement.php?id=3" class="card">
      <img src="../loft marseille.webp" alt="Maison">
      <div class="info">
        <h4>Villa moderne avec piscine</h4>
        <p>Marseille, France</p>
        <span>120€/nuit</span>
      </div>
    </a>

    <a href="../affichage_hebergement.php?id=2" class="card">
      <img src="../chalet.webp" alt="Loft">
      <div class="info">
        <h4>Chalet a la montagne </h4>
        <p>Lyon, France</p>
        <span>90€/nuit</span>
      </div>
    </a>

    <a href="../affichage_hebergement.php?id=1" class="card">
      <img src="../bungalow.webp" alt="Chalet">
      <div class="info">
        <h4>Bungalow cosy </h4>
        <p>Chamonix, France</p>
        <span>150€/nuit</span>
      </div>
    </a>

  </div> <!-- .cards -->

</section>

<footer>
  <p>&copy; 2025 MyBnB - Tous droits réservés</p>
</footer>


</body>
</html>
