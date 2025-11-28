<?php
// admin/produtos.php

$menu = 'produtos';

require_once __DIR__ . '/config/guard.php';
guard_require();

require_once __DIR__ . '/ferriso_api.php'; // já puxa o db.php lá dentro

// trata ações de toggle (POST) e mantém ordenação via GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $id   = (int)($_POST['id'] ?? 0);
    $novo = (int)($_POST['novo'] ?? 0) === 1;

    try {
        if ($acao === 'toggle_ativo' && $id > 0) {
            ferriso_set_ativo($con, 'produtos', $id, $novo);
        } elseif ($acao === 'toggle_destaque' && $id > 0) {
            ferriso_set_destaque($con, 'produtos', $id, $novo);
        }
    } catch (Throwable $e) {
        // se quiser, armazena mensagem em $erro pra exibir abaixo
        $erro = 'Erro ao atualizar produto: ' . $e->getMessage();
    }

    // redireciona de volta mantendo ordenação
    $params = $_GET;
    $qs     = $params ? ('?' . http_build_query($params)) : '';
    header('Location: produtos.php' . $qs);
    exit;
}

// ordenação
$allowedOrder = [
    'nome'         => 'Nome',
    'categoria'    => 'Categoria',
    'criado_em'    => 'Data de criação',
    'atualizado_em'=> 'Última atualização',
    'ativo'        => 'Status (ativo)',
    'destaque'     => 'Destaque',
];

$order = $_GET['order'] ?? 'nome';
$dir   = $_GET['dir']   ?? 'asc';

if (!array_key_exists($order, $allowedOrder)) {
    $order = 'nome';
}
$dir = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

// busca produtos já ordenados
$produtos = ferriso_list_produtos($con, false, $order, $dir);

// nav + sidebar
require __DIR__ . '/partials/nav.php';
?>

<!-- CONTENT WRAPPER -->
<div class="content-wrapper">

  <!-- CABEÇALHO -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Produtos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active">Produtos</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTEÚDO PRINCIPAL -->
  <section class="content">
    <div class="container-fluid">

      <style>
        :root {
          --ferriso-navy-900: #001426;
        }

        .card-navy-custom {
          background-color: #001325;
          border-radius: 1rem;
          border: 1px solid rgba(15, 23, 42, 0.7);
          box-shadow: 0 18px 40px rgba(0, 0, 0, .6);
        }

        .card-navy-custom .card-header {
          border-bottom: 1px solid rgba(148, 163, 184, .5);
        }

        .card-navy-custom .card-title {
          font-weight: 600;
          color: #e5e7eb;
        }

        .card-navy-custom .table {
          color: #e5e7eb;
        }

        .card-navy-custom .table thead th {
          border-top: none;
          border-bottom-color: rgba(148, 163, 184, .4);
          font-size: .85rem;
          text-transform: uppercase;
          letter-spacing: .04em;
          color: #9ca3af;
        }

        .card-navy-custom .table tbody td {
          border-top-color: rgba(55, 65, 81, .6);
          vertical-align: middle;
        }

        .badge-cat {
          font-size: .78rem;
          border-radius: .6rem;
          padding: .2rem .55rem;
          background-color: rgba(15, 23, 42, .7);
          color: #e5e7eb;
          border: 1px solid rgba(148, 163, 184, .6);
        }

        .thumb-produto {
          width: 52px;
          height: 52px;
          border-radius: .6rem;
          object-fit: cover;
          border: 1px solid rgba(148, 163, 184, .6);
          background-color: #020617;
        }

        .status-icon {
          font-size: 1rem;
        }

        .status-icon + .status-icon {
          margin-left: .35rem;
        }

        .btn-icon {
          border: none;
          background: transparent;
          padding: 0;
          margin: 0;
        }

        .btn-icon + .btn-icon,
        .btn-icon + a {
          margin-left: .6rem;
        }

        .btn-icon i,
        .link-icon i {
          font-size: 1rem;
        }

        .link-icon {
          text-decoration: none;
        }

        .table-responsive {
          border-radius: .85rem;
          overflow: hidden;
        }
      </style>

      <div class="card card-navy-custom">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
          <h3 class="card-title mb-2 mb-sm-0">
            <i class="fas fa-boxes mr-2"></i> Lista de produtos
          </h3>

          <div class="d-flex flex-wrap align-items-center">
            <form method="get" class="form-inline mb-2 mb-sm-0">
              <label class="mr-2 text-sm text-light">Ordenar por:</label>
              <select name="order" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <?php foreach ($allowedOrder as $key => $label): ?>
                  <option value="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    <?= $order === $key ? 'selected' : '' ?>>
                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <select name="dir" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="asc"  <?= strtolower($dir) === 'asc' ? 'selected' : '' ?>>Crescente</option>
                <option value="desc" <?= strtolower($dir) === 'desc' ? 'selected' : '' ?>>Decrescente</option>
              </select>
            </form>

            <a href="produto_editar.php" class="btn btn-sm btn-primary ml-sm-3 mt-2 mt-sm-0">
              <i class="fas fa-plus"></i> Novo produto
            </a>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th style="width: 50px;">Img</th>
                  <th>Nome</th>
                  <th style="width: 140px;">Categoria</th>
                  <th>Resumo</th>
                  <th style="width: 110px;" class="text-center">Status</th>
                  <th style="width: 110px;" class="text-right">Ações</th>
                </tr>
              </thead>
              <tbody>
              <?php if (empty($produtos)): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    Nenhum produto cadastrado.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($produtos as $p): ?>
                  <?php
                    $ativo    = (int)$p['ativo'] === 1;
                    $destaque = (int)$p['destaque'] === 1;
                    $img      = $p['capa_img'] ? '../img/' . ltrim($p['capa_img'], '/') : '';
                  ?>
                  <tr>
                    <!-- Imagem -->
                    <td>
                      <?php if ($img): ?>
                        <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>"
                             alt="<?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?>"
                             class="thumb-produto">
                      <?php else: ?>
                        <div class="thumb-produto d-flex align-items-center justify-content-center text-muted">
                          <i class="far fa-image"></i>
                        </div>
                      <?php endif; ?>
                    </td>

                    <!-- Nome + slug -->
                    <td>
                      <div class="font-weight-semibold">
                        <?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?>
                      </div>
                      <div class="text-muted small">
                        slug: <?= htmlspecialchars($p['slug'], ENT_QUOTES, 'UTF-8') ?>
                      </div>
                    </td>

                    <!-- Categoria -->
                    <td>
                      <span class="badge-cat">
                        <?= htmlspecialchars($p['categoria'], ENT_QUOTES, 'UTF-8') ?>
                      </span>
                    </td>

                    <!-- Resumo -->
                    <td>
                      <span class="text-light small">
                        <?= htmlspecialchars($p['resumo'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                      </span>
                    </td>

                    <!-- Status (só ícones) -->
                    <td class="text-center">
                      <!-- ativo/inativo -->
                      <?php if ($ativo): ?>
                        <span class="status-icon text-success" title="Ativo">
                          <i class="fas fa-circle"></i>
                        </span>
                      <?php else: ?>
                        <span class="status-icon text-muted" title="Inativo">
                          <i class="far fa-circle"></i>
                        </span>
                      <?php endif; ?>

                      <!-- destaque/sem destaque -->
                      <?php if ($destaque): ?>
                        <span class="status-icon text-warning" title="Em destaque">
                          <i class="fas fa-star"></i>
                        </span>
                      <?php else: ?>
                        <span class="status-icon text-muted" title="Sem destaque">
                          <i class="far fa-star"></i>
                        </span>
                      <?php endif; ?>
                    </td>

                    <!-- Ações (só ícones) -->
                    <td class="text-right text-nowrap">

                      <!-- Toggle destaque (estrela) -->
                      <form method="post" class="d-inline">
                        <input type="hidden" name="acao" value="toggle_destaque">
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <input type="hidden" name="novo" value="<?= $destaque ? 0 : 1 ?>">
                        <button type="submit"
                                class="btn-icon text-warning"
                                title="<?= $destaque ? 'Remover destaque' : 'Marcar como destaque' ?>">
                          <i class="<?= $destaque ? 'fas' : 'far' ?> fa-star"></i>
                        </button>
                      </form>

                      <!-- Toggle ativo (olho) -->
                      <form method="post" class="d-inline">
                        <input type="hidden" name="acao" value="toggle_ativo">
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <input type="hidden" name="novo" value="<?= $ativo ? 0 : 1 ?>">
                        <button type="submit"
                                class="btn-icon text-info"
                                title="<?= $ativo ? 'Desativar produto' : 'Ativar produto' ?>">
                          <i class="fas fa-eye<?= $ativo ? '' : '-slash' ?>"></i>
                        </button>
                      </form>

                      <!-- Editar (lápis) -->
                      <a href="produto_editar.php?id=<?= (int)$p['id'] ?>"
                         class="btn-icon link-icon text-light"
                         title="Editar produto">
                        <i class="fas fa-pencil-alt"></i>
                      </a>

                      <!-- Excluir REMOVIDO por enquanto -->
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
