<?php
require_once __DIR__.'/config/database.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $s=$pdo->prepare("SELECT * FROM users WHERE username=?");$s->execute([trim($_POST['username'])]);$u=$s->fetch();
 if($u && password_verify($_POST['password'],$u['password'])){$_SESSION['user_id']=$u['id'];$_SESSION['username']=$u['username'];header('Location:index.php');exit;}
 $msg='Usuario o contraseña incorrectos.';
}
?><!DOCTYPE html><html lang="es"><head><?php include __DIR__.'/partials/head.php';?></head><body><?php include __DIR__.'/partials/nav.php';?><main class="auth"><div class="auth-box"><p class="eyebrow">✦ ACCESO</p><h1>Bienvenido de vuelta</h1><?php if($msg):?><div class="error"><?=$msg?></div><?php endif;?><form method="post"><input name="username" placeholder="Usuario" required><input type="password" name="password" placeholder="Contraseña" required><button class="btn">Entrar</button></form><p class="muted">¿No tienes cuenta? <a href="register.php">Regístrate</a></p></div></main></body></html>