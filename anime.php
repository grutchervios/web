<?php
require_once __DIR__.'/config/database.php';
$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("SELECT a.*, COALESCE(AVG(r.rating),0) avg_rating, COUNT(r.id) rating_count FROM animes a LEFT JOIN ratings r ON r.anime_id=a.id WHERE a.id=? GROUP BY a.id");
$stmt->execute([$id]); $anime=$stmt->fetch();
if(!$anime){http_response_code(404);exit('Anime no encontrado');}
$c=$pdo->prepare("SELECT c.*,u.username FROM comments c JOIN users u ON u.id=c.user_id WHERE c.anime_id=? ORDER BY c.created_at DESC"); $c->execute([$id]); $comments=$c->fetchAll();
?>
<!DOCTYPE html><html lang="es"><head><?php include __DIR__.'/partials/head.php'; ?></head><body>
<?php include __DIR__.'/partials/nav.php'; ?>
<main class="container">
<section class="anime-detail">
  <img class="detail-cover" src="<?=htmlspecialchars($anime['cover'])?>" onerror="this.src='assets/images/placeholder.svg'">
  <div class="detail-info">
    <p class="eyebrow">ANIME</p><h1><?=htmlspecialchars($anime['title'])?></h1>
    <p class="muted"><?=htmlspecialchars($anime['year'])?></p>
    <div class="big-rating"><?=str_repeat('★', round($anime['avg_rating'])).str_repeat('☆',5-round($anime['avg_rating']))?></div>
    <p><?=nl2br(htmlspecialchars($anime['description']))?></p>
    <?php if(isset($_SESSION['user_id'])): ?>
      <form action="api/rating.php" method="post" class="rating-form"><input type="hidden" name="anime_id" value="<?=$id?>">
        <label>Tu valoración</label><select name="rating"><?php for($i=1;$i<=5;$i++): ?><option value="<?=$i?>"><?=$i?> ★</option><?php endfor;?></select><button class="btn small">Valorar</button>
      </form>
      <form action="api/comment.php" method="post" class="comment-form"><input type="hidden" name="anime_id" value="<?=$id?>"><textarea name="content" maxlength="1000" placeholder="¿Qué te ha parecido?"></textarea><button class="btn">Comentar</button></form>
    <?php else: ?><p class="notice">Inicia sesión para valorar y comentar.</p><?php endif; ?>
  </div>
</section>
<section class="comments"><div class="section-title"><h2>Comentarios</h2><span class="muted"><?=count($comments)?></span></div>
<?php foreach($comments as $comment): ?><article class="comment"><b><?=htmlspecialchars($comment['username'])?></b><span class="muted"><?=htmlspecialchars($comment['created_at'])?></span><p><?=nl2br(htmlspecialchars($comment['content']))?></p></article><?php endforeach; if(!$comments):?><p class="muted">Todavía no hay comentarios.</p><?php endif;?>
</section></main><?php include __DIR__.'/partials/footer.php';?></body></html>