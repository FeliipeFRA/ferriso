<?php
require_once __DIR__ . '/../config/guard.php';

// garante que só entra logado
guard_require();

$user = guard_user();
$userNome = $user['nome'] ?? 'Usuário';

// gera iniciais do nome (ex: Felipe Ferreira -> FF)
function user_initials(string $nome): string {
    $nome = trim($nome);
    if ($nome === '') return '?';

    $partes   = preg_split('/\s+/', $nome);
    $primeiro = $partes[0] ?? '';
    $ultimo   = $partes[count($partes) - 1] ?? $primeiro;

    if (function_exists('mb_substr')) {
        $i1 = mb_substr($primeiro, 0, 1, 'UTF-8');
        $i2 = mb_substr($ultimo,   0, 1, 'UTF-8');
    } else {
        $i1 = substr($primeiro, 0, 1);
        $i2 = substr($ultimo,   0, 1);
    }

    $iniciais = $i1 . $i2;

    return function_exists('mb_strtoupper')
        ? mb_strtoupper($iniciais, 'UTF-8')
        : strtoupper($iniciais);
}

$userIniciais = user_initials($userNome);

// qual menu está ativo nesta página (dashboard, projetos, produtos, avaliacoes)
$menu = $menu ?? 'home';
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel Admin - Ferriso Isolações</title>

  <meta name="robots" content="noindex,nofollow">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
  <!-- Favicon (ajuste se o favicon estiver em outro lugar) -->
  <link href="../img/favicon.ico" rel="icon">
</head>

<body class="hold-transition sidebar-mini layout-fixed accent-danger">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark bg-navy">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://ferrisoisolamentos.com.br" target="_blank" class="nav-link">
          Ver site
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar bg-navy text-white border-0"
                     type="search" placeholder="Buscar no painel" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- User / Logout -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            <?php echo htmlspecialchars($userNome, ENT_QUOTES, 'UTF-8'); ?>
          </span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user-cog mr-2"></i> Perfil
          </a>
          <div class="dropdown-divider"></div>
          <a href="/admin/config/logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Sair
          </a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-navy bg-navy elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link bg-navy d-flex align-items-center justify-content-center">
      <img src="../img/logo_admin.png"
           alt="Ferriso Isolações Térmicas"
           class="img-fluid"
           style="max-height:40px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar bg-navy">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <div class="d-flex align-items-center justify-content-center bg-danger text-white rounded-circle"
               style="width: 36px; height: 36px; font-weight: 600;">
            <?php echo htmlspecialchars($userIniciais, ENT_QUOTES, 'UTF-8'); ?>
          </div>
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <strong><?php echo htmlspecialchars($userNome, ENT_QUOTES, 'UTF-8'); ?></strong>
          </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar bg-navy text-white border-0"
                 type="search" placeholder="Buscar" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar bg-navy border-0">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-flat nav-compact flex-column"
            data-widget="treeview" role="menu" data-accordion="false">
          
          <!-- Dashboard -->
          <li class="nav-item">
            <a href="home.php"
               class="nav-link <?php echo $menu === 'home' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>Pagina Inicial</p>
            </a>
          </li>

          <li class="nav-header">Conteúdo do site</li>

          <!-- Projetos -->
          <li class="nav-item">
            <a href="projetos.php"
               class="nav-link <?php echo $menu === 'projetos' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-hard-hat"></i>
              <p>Projetos</p>
            </a>
          </li>

          <!-- Produtos -->
          <li class="nav-item">
            <a href="produtos.php"
               class="nav-link <?php echo $menu === 'produtos' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Produtos</p>
            </a>
          </li>

          <!-- Avaliações -->
          <li class="nav-item">
            <a href="avaliacoes.php"
               class="nav-link <?php echo $menu === 'avaliacoes' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-comments"></i>
              <p>Avaliações</p>
            </a>
          </li>

          <!-- Contatos -->
          <li class="nav-item">
            <a href="contatos.php"
               class="nav-link <?php echo $menu === 'contatos' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-envelope"></i>
              <p>Contatos</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
