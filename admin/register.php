<?php require_once __DIR__.'/config/php_init.php'; ?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Registrar | Ferriso Admin</title>
  <meta name="robots" content="noindex,nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <h1>Criar acesso</h1>
  <?php if (!empty($_GET['err'])): ?>
    <p style="color:#c00">Erro: <?php echo htmlspecialchars($_GET['err']); ?></p>
  <?php endif; ?>

  <form action="/config/auth_register.php" method="post" novalidate>
  <input type="hidden" name="csrf" value="<?php
    require_once __DIR__.'/config/php_init.php'; echo htmlspecialchars(csrf_token(), ENT_QUOTES); ?>">
  <input name="nome" type="text" required>
  <input name="login" type="text" required>
  <input name="senha" type="password" required>
  <input name="confirma" type="password" required>
  <button type="submit">Registrar</button>
</form>

  <p>Já tem conta? <a href="/admin/login.php">Entrar</a></p>
</body>
</html>
