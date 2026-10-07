<?php
require_once __DIR__ . '/config/database.php';
$animes = $pdo->query("SELECT a.*, COALESCE(AVG(r.rating),0) avg_rating, COUNT(r.id) rating_count FROM animes a LEFT JOIN ratings r ON r.anime_id=a.id GROUP BY a.id ORDER BY a.created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><?php include __DIR__.'/partials/head.php'; ?></head>
<body>
<?php include __DIR__.'/partials/nav.php'; ?>
<main class="container">
  <section class="hero">
    <div>
      <p class="eyebrow">✦ ANIMEVERSE ✦</p>
      <h1>Tu rincón <span>anime</span> en Internet.</h1>
      <p class="hero-copy">Guarda tus animes, puntúalos, escribe reseñas y habla con otros fans.</p>
      <div class="hero-actions"><a class="btn" href="#catalogo">Explorar anime</a><a class="btn ghost" href="forum.php">Entrar al foro</a></div>
    </div>
    <div class="hero-orb"><span>五等分</span><small>NEON OTaku SPACE</small></div>
  </section>

  <section id="catalogo">
    <div class="section-title"><div><p class="eyebrow">CATÁLOGO</p><h2>Últimos añadidos</h2></div><a href="add-anime.php" class="btn small">＋ Añadir anime</a></div>
    <div class="anime-grid">
      <?php foreach($animes as $anime): ?>
      <article class="anime-card">
        <a href="anime.php?id=<?= (int)$anime['id'] ?>">
          <div class="cover-wrap"><img src="<?= htmlspecialchars($anime['cover']) ?>" alt="<?= htmlspecialchars($anime['title']) ?>" onerror="this.src='assets/images/placeholder.svg'"></div>
          <div class="card-body">
            <h3><?= htmlspecialchars($anime['title']) ?></h3>
            <p class="muted"><?= (int)$anime['year'] ?></p>
            <div class="rating"><span><?= str_repeat('★', round($anime['avg_rating'])) . str_repeat('☆', 5-round($anime['avg_rating'])) ?></span> <b><?= number_format((float)$anime['avg_rating'],1) ?></b></div>
          </div>
        </a>
      </article>
      <?php endforeach; ?>
    </div>
  </section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
</body></html>