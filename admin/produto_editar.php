<?php
// página atual (menu ativo)
$menu = 'produtos';

require_once __DIR__ . '/config/guard.php';
guard_require();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/ferriso_api.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    // volta para a lista
    if (function_exists('redirect')) {
        redirect('produtos.php');
    } else {
        header('Location: produtos.php');
        exit;
    }
}

$flashOk   = '';
$flashErro = '';
$produto   = ferriso_get_produto($con, $id);

if (!$produto) {
    if (function_exists('redirect')) {
        redirect('produtos.php');
    } else {
        header('Location: produtos.php');
        exit;
    }
}

// submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (function_exists('csrf_check') && !csrf_check($_POST['csrf'] ?? '')) {
        $flashErro = 'Sua sessão expirou. Atualize a página e tente novamente.';
    } else {
        try {
            $data = [
                'nome'      => $_POST['nome']      ?? '',
                'categoria' => $_POST['categoria'] ?? '',
                'slug'      => $_POST['slug']      ?? '',
                'resumo'    => $_POST['resumo']    ?? '',
                'descricao' => $_POST['descricao'] ?? '',
                'capa_img'  => $_POST['capa_img']  ?? '',
                'ativo'     => isset($_POST['ativo']) ? 1 : 0,
                'destaque'  => isset($_POST['destaque']) ? 1 : 0,
            ];

            ferriso_atualizar_produto($con, $id, $data);
            $flashOk = 'Produto atualizado com sucesso.';

            // recarrega dados atualizados
            $produto = ferriso_get_produto($con, $id);

        } catch (Throwable $e) {
            $flashErro = 'Erro ao salvar: ' . $e->getMessage();
        }
    }
}

// nav + sidebar
require __DIR__ . '/partials/nav.php';
?>

<div class="content-wrapper">

    <!-- cabeçalho padrão -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar produto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="produtos.php">Produtos</a></li>
                        <li class="breadcrumb-item active">Editar</li>
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
                    --ferriso-navy-800: #00253f;
                    --ferriso-navy-700: #003a63;
                    --ferriso-highlight: #ff3939ff;
                }

                .edit-hero {
                    position: relative;
                    overflow: hidden;
                    border-radius: 1.25rem;
                    padding: 1.4rem 1.8rem;
                    color: #ffffff;
                    box-shadow: 0 18px 42px rgba(0, 0, 0, 0.55);
                    background:
                        radial-gradient(800px 400px at -10% -10%, rgba(255,255,255,0.06), transparent 60%),
                        radial-gradient(900px 480px at 120% -10%, rgba(253,126,20,0.12), transparent 70%),
                        linear-gradient(130deg, var(--ferriso-navy-900) 0%, var(--ferriso-navy-800) 45%, var(--ferriso-navy-700) 100%);
                }

                .edit-hero h2 {
                    font-size: 1.45rem;
                    font-weight: 700;
                    margin-bottom: .25rem;
                }

                .edit-hero .subtitle {
                    font-size: .9rem;
                    color: rgba(255,255,255,.8);
                }

                .edit-hero-right {
                    text-align: right;
                    font-size: .8rem;
                    color: #cbd5f5;
                }

                .badge-soft-warning {
                    display: inline-flex;
                    align-items: center;
                    padding: .25rem .55rem;
                    border-radius: 999px;
                    font-size: .75rem;
                    font-weight: 600;
                    background: rgba(245,158,11,.16);
                    color: #fef3c7;
                    border: 1px solid rgba(245,158,11,.55);
                }

                .card-navy {
                    background-color: #001325ff;
                    border-radius: 1.05rem;
                    border: 1px solid rgba(15, 23, 42, 0.75);
                    color: #e5e7eb;
                    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.55);
                }

                .card-navy .card-header {
                    border-bottom: 1px solid rgba(15, 23, 42, 0.8);
                }

                .help-text {
                    font-size: .78rem;
                    color: #9ca3af;
                }

                .thumb-preview {
                    width: 100%;
                    max-width: 260px;
                    border-radius: .8rem;
                    background: rgba(15,23,42,.9);
                    object-fit: cover;
                    box-shadow: 0 10px 26px rgba(0,0,0,.6);
                }

                @media (max-width: 991.98px) {
                    .edit-hero {
                        padding: 1.2rem 1.2rem;
                    }
                    .edit-hero-right {
                        text-align: left;
                        margin-top: .75rem;
                    }
                }
            </style>

            <!-- HERO -->
            <div class="edit-hero mb-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-12">
                        <h2>
                            Editando: <?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8'); ?>
                        </h2>
                        <p class="subtitle mb-0">
                            Ajuste as informações abaixo. O slug é usado na URL da página do produto;
                            se deixar em branco será gerado automaticamente a partir do nome.
                        </p>
                    </div>
                    <div class="col-lg-4 col-12 edit-hero-right">
                        <div class="mb-1">
                            <span class="badge-soft-warning">
                                ID <?= (int)$produto['id']; ?> · criado em
                                <?= htmlspecialchars(date('d/m/Y', strtotime($produto['criado_em'] ?? 'now')), ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                        <div>
                            Slug atual:
                            <strong><?= htmlspecialchars($produto['slug'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ALERTAS -->
            <?php if ($flashOk): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($flashOk, ENT_QUOTES, 'UTF-8'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($flashErro): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($flashErro, ENT_QUOTES, 'UTF-8'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- FORM + PREVIEW -->
            <div class="card card-navy">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-box mr-2"></i> Dados do produto
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- FORMULÁRIO -->
                        <div class="col-lg-8 col-12">
                            <form method="post">
                                <?php if (function_exists('csrf_token')): ?>
                                    <input type="hidden" name="csrf"
                                           value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <?php endif; ?>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nome">Nome</label>
                                        <input type="text" name="nome" id="nome"
                                               class="form-control form-control-sm"
                                               required
                                               value="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="categoria">Categoria</label>
                                        <select name="categoria" id="categoria" class="form-control form-control-sm">
                                            <?php
                                            $cats = [
                                                'revestimento_metalico' => 'Revestimento metálico',
                                                'isolantes_termicos'    => 'Isolantes térmicos',
                                                'acessorios'            => 'Acessórios',
                                                'outros'                => 'Outros'
                                            ];
                                            foreach ($cats as $val => $label):
                                            ?>
                                                <option value="<?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>"
                                                    <?= $produto['categoria'] === $val ? 'selected' : ''; ?>>
                                                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="slug">Slug (URL)</label>
                                        <input type="text" name="slug" id="slug"
                                               class="form-control form-control-sm"
                                               placeholder="deixe em branco para gerar automático"
                                               value="<?= htmlspecialchars($produto['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <small class="help-text">
                                            Exemplo: <code>silicato-de-calcio</code>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="resumo">Resumo curto</label>
                                    <input type="text" name="resumo" id="resumo"
                                           class="form-control form-control-sm"
                                           value="<?= htmlspecialchars($produto['resumo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <small class="help-text">
                                        Aparece nos cards de produtos e listagens internas.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="descricao">Descrição detalhada</label>
                                    <textarea name="descricao" id="descricao"
                                              rows="6"
                                              class="form-control form-control-sm"><?= htmlspecialchars($produto['descricao'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                                    <small class="help-text">
                                        Descrição técnica / comercial exibida na página interna do produto.
                                    </small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="capa_img">Capa (caminho da imagem)</label>
                                        <input type="text" name="capa_img" id="capa_img"
                                               class="form-control form-control-sm"
                                               value="<?= htmlspecialchars($produto['capa_img'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        <small class="help-text">
                                            Caminho relativo dentro de <code>img/</code>. Ex.: <code>produtos/telhas.png</code>
                                        </small>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="ativo" id="ativo"
                                                <?= !empty($produto['ativo']) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="ativo">
                                                Ativo (visível no site)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="destaque" id="destaque"
                                                <?= !empty($produto['destaque']) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="destaque">
                                                Destaque na home
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save mr-1"></i> Salvar alterações
                                </button>
                                <a href="produtos.php" class="btn btn-secondary btn-sm">
                                    Voltar para lista
                                </a>
                            </form>
                        </div>

                        <!-- PREVIEW -->
                        <div class="col-lg-4 col-12 mt-4 mt-lg-0">
                            <h6 class="mb-2">Pré-visualização da capa</h6>
                            <?php if (!empty($produto['capa_img'])): ?>
                                <img src="../img/<?= htmlspecialchars($produto['capa_img'], ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="Preview"
                                     class="thumb-preview mb-2"
                                     onerror="this.style.display='none';">
                            <?php else: ?>
                                <div class="help-text mb-2">
                                    Nenhuma imagem definida. Informe o caminho da imagem em
                                    <strong>Capa</strong> e salve para visualizar aqui.
                                </div>
                            <?php endif; ?>

                            <p class="help-text">
                                As imagens são carregadas a partir da pasta
                                <code>img/</code> do site. Certifique-se de enviar o arquivo
                                para o servidor com o mesmo caminho informado.
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
