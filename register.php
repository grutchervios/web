<?php
require_once __DIR__.'/config/database.php'; $msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $u=trim($_POST['username']);$e=trim($_POST['email']);$p=$_POST['password'];
 if(strlen($u)<3||strlen($p)<6)$msg='Usuario mínimo 3 caracteres y contraseña mínimo 6.';
 else {try{$s=$pdo->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?)");$s->execute([$u,$e,password_hash($p,PASSWORD_DEFAULT)]);header('Location:login.php');exit;}catch(PDOException $x){$msg='Ese usuario o email ya existe.';}}
}
?><!DOCTYPE html><html lang="es"><head><?php include __DIR__.'/partials/head.php';?></head><body><?php include __DIR__.'/partials/nav.php';?><main class="auth"><div class="auth-box"><p class="eyebrow">✦ REGISTRO</p><h1>Crea tu cuenta</h1><?php if($msg):?><div class="error"><?=$msg?></div><?php endif;?><form method="post"><input name="username" placeholder="Usuario" required><input type="email" name="email" placeholder="Email" required><input type="password" name="password" placeholder="Contraseña" required><button class="btn">Crear cuenta</button></form></div></main></body></html>