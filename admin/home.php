<?php
// página atual (menu ativo)
$menu = 'dashboard';

// protege a página
require_once __DIR__ . '/config/guard.php';
guard_require();

// usuário logado
$user         = guard_user();
$nomeCompleto = $user['nome'] ?? 'Usuário';

function first_name(string $s): string
{
    $s = trim($s);
    if ($s === '') return 'Usuário(a)';
    $parts = preg_split('/\s+/', $s);
    $first = $parts[0] ?? 'Usuário(a)';
    if (function_exists('mb_convert_case')) {
        $first = mb_convert_case(mb_strtolower($first, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    } else {
        $first = ucfirst(strtolower($first));
    }
    return $first ?: 'Usuário(a)';
}
$firstName = first_name($nomeCompleto);

// conexão com o banco
require_once __DIR__ . '/../config/db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// funções de contagem
function contar_ativos(mysqli $con, string $tabela): int
{
    $sql = "SELECT COUNT(*) AS total FROM {$tabela} WHERE ativo = 1";
    $res = $con->query($sql);
    $row = $res->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function contar_contatos_total(mysqli $con): int
{
    $sql = "SELECT COUNT(*) AS total FROM contatos";
    $res = $con->query($sql);
    $row = $res->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

function contar_contatos_cond(mysqli $con, string $coluna): int
{
    // coluna deve ser 'lido' ou 'respondido'
    $coluna = $coluna === 'respondido' ? 'respondido' : 'lido';
    $sql = "SELECT COUNT(*) AS total FROM contatos WHERE {$coluna} = 0";
    $res = $con->query($sql);
    $row = $res->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

// contadores principais
$totProjetos   = contar_ativos($con, 'projetos');
$totProdutos   = contar_ativos($con, 'produtos');
$totAvaliacoes = contar_ativos($con, 'avaliacoes');

// contatos
$totContatos        = contar_contatos_total($con);
$contatosNaoLidos   = contar_contatos_cond($con, 'lido');
$contatosNaoResp    = contar_contatos_cond($con, 'respondido');

// nav + sidebar
require __DIR__ . '/partials/nav.php';
?>

<!-- CONTENT WRAPPER -->
<div class="content-wrapper">

    <!-- CABEÇALHO DA PÁGINA -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pagina Inicial</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTEÚDO PRINCIPAL -->
    <section class="content">
        <div class="container-fluid">

            <!-- ESTILOS LOCAIS -->
            <style>
                :root {
                    --ferriso-navy-900: #001426;
                    --ferriso-navy-800: #00253f;
                    --ferriso-navy-700: #003a63;
                    --ferriso-highlight: #ff3939ff;
                }

                .dashboard-hero {
                    position: relative;
                    overflow: hidden;
                    border-radius: 1.25rem;
                    padding: 2rem 2.25rem;
                    color: #ffffff;
                    box-shadow: 0 18px 42px rgba(0, 0, 0, 0.55);

                    /* imagem de fundo + ajuste */
                    background-image: url('../img/carousel-1.jpg');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                }

                /* camada de gradiente azul por cima da imagem */
                .dashboard-hero::before {
                    content: "";
                    position: absolute;
                    inset: 0;
                    background:
                        radial-gradient(700px 400px at -10% 0%, rgba(255, 255, 255, 0.05), transparent 60%),
                        radial-gradient(900px 480px at 120% -10%, rgba(253, 126, 20, 0.12), transparent 70%),
                        linear-gradient(130deg, var(--ferriso-navy-900) 0%, var(--ferriso-navy-800) 38%, var(--ferriso-navy-700) 100%);
                    opacity: 0.92;
                    /* deixa a foto levemente visível por baixo */
                    z-index: 0;
                }

                /* brilho adicional à direita (opcional) */
                .dashboard-hero::after {
                    content: "";
                    position: absolute;
                    right: -120px;
                    bottom: -120px;
                    width: 360px;
                    height: 360px;
                    background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.28), transparent 65%);
                    opacity: 0.18;
                    filter: blur(12px);
                    z-index: 0;
                }

                .dashboard-hero>.row {
                    position: relative;
                    z-index: 1;
                    /* conteúdo acima da imagem/gradiente */
                }

                .hero-highlight {
                    display: inline-flex;
                    align-items: center;
                    padding: .45rem .85rem;
                    border-radius: 999px;
                    font-size: .8rem;
                    font-weight: 600;
                    letter-spacing: .06em;
                    text-transform: uppercase;
                    background: linear-gradient(90deg, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0.03));
                    border: 1px solid rgba(255, 255, 255, 0.14);
                    color: rgba(255, 255, 255, 0.9);
                }

                .hero-highlight span {
                    color: var(--ferriso-highlight);
                    margin-left: .35rem;
                }

                .dashboard-hero h1 {
                    font-size: 1.9rem;
                    font-weight: 700;
                    margin-bottom: .35rem;
                }

                .dashboard-hero .subtitle {
                    color: rgba(255, 255, 255, 0.78);
                    font-size: .95rem;
                }

                .hero-meta-line {
                    margin-top: 1.3rem;
                    font-size: .88rem;
                    color: rgba(255, 255, 255, 0.75);
                }

                .hero-meta-line i {
                    margin-right: .35rem;
                }

                .hero-alert {
                    margin-top: 1.2rem;
                    display: inline-flex;
                    flex-wrap: wrap;
                    align-items: center;
                    gap: .5rem .75rem;
                    padding: .7rem 1rem;
                    border-radius: .9rem;
                    background: linear-gradient(120deg,
                            rgba(15, 23, 42, 0.9),
                            rgba(15, 23, 42, 0.95));
                    border: 1px solid rgba(148, 163, 184, .6);
                    font-size: .85rem;
                    color: #e5e7eb;
                }

                .hero-alert i {
                    color: #fbbf24;
                }

                .hero-alert strong {
                    font-weight: 600;
                }

                .hero-alert-link {
                    font-weight: 600;
                    text-decoration: none;
                    color: #bfdbfe;
                }

                .hero-alert-link:hover {
                    color: #e5edff;
                    text-decoration: underline;
                }

                /* logo grande à direita */
                .hero-side-logo {
                    position: relative;
                    padding: 1.4rem 1.7rem;
                    border-radius: 1.6rem;
                    background: rgba(0, 0, 0, 0.18);
                    backdrop-filter: blur(8px);
                    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.65);
                }

                .hero-side-logo img {
                    display: block;
                    max-height: 130px;
                    /* tamanho grande */
                    width: auto;
                    filter: drop-shadow(0 10px 26px rgba(0, 0, 0, 0.9));
                }

                /* logo pequena para mobile (texto) */
                .hero-logo-mobile img {
                    max-height: 34px;
                    width: auto;
                    display: block;
                    margin-bottom: .75rem;
                }

                @media (max-width: 991.98px) {
                    .dashboard-hero {
                        padding: 1.5rem 1.4rem;
                    }
                }

                /* cards resumo */
                .summary-row {
                    margin-top: 1.75rem;
                }

                .summary-card {
                    background-color: #001325ff;
                    /* navy padrão AdminLTE */
                    border-radius: 1.05rem;
                    border: 1px solid rgba(15, 23, 42, 0.75);
                    padding: 1.1rem 1.2rem;
                    color: #e5e7eb;
                    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.55);
                    height: 100%;
                    /* todos com a mesma altura dentro da coluna */
                    display: flex;
                    flex-direction: column;
                }

                .summary-card-header {
                    display: flex;
                    align-items: center;
                    margin-bottom: .9rem;
                }

                .summary-icon {
                    width: 40px;
                    height: 40px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-right: .75rem;
                    background: rgba(15, 23, 42, 0.65);
                    /* navy mais escuro dentro do card */
                    color: #fefce8;
                    font-size: 1.1rem;
                }

                .summary-title {
                    font-size: .98rem;
                    font-weight: 600;
                }

                .summary-subtitle {
                    font-size: .8rem;
                    color: #cbd5f5;
                }

                .summary-number {
                    font-size: 1.9rem;
                    font-weight: 700;
                    color: #f9fafb;
                    line-height: 1.1;
                }

                .summary-footnote {
                    font-size: .78rem;
                    color: #cbd5f5;
                    margin-top: .2rem;
                }

                .summary-footer {
                    margin-top: 1rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    font-size: .78rem;
                    color: #cbd5f5;
                }

                .btn-summary-link {
                    font-size: .8rem;
                    font-weight: 600;
                    text-decoration: none;
                    color: #93c5fd;
                    display: inline-flex;
                    align-items: center;
                    gap: .25rem;
                }

                .btn-summary-link:hover {
                    color: #e0f2fe;
                    text-decoration: none;
                }


                @media (max-width: 991.98px) {
                    .dashboard-hero {
                        padding: 1.5rem 1.4rem;
                    }
                }
            </style>

            <!-- HERO NAVY COM IMAGEM AO FUNDO -->
            <div class="dashboard-hero mb-4">
                <div class="row align-items-center">

                    <!-- LADO ESQUERDO: texto -->
                    <div class="col-lg-7 col-12">

                        <!-- logo pequena no mobile -->
                        <div class="hero-logo-mobile d-lg-none">
                            <img src="../img/logo_admin.png" alt="Ferriso Isolações Térmicas">
                        </div>

                        <div class="hero-highlight mb-3">
                            Painel administrativo
                            <span>Ferriso Isolações</span>
                        </div>

                        <h1>Bem-vindo, <?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?>.</h1>
                        <p class="subtitle mb-0">
                            Aqui você acompanha o conteúdo publicado no site: projetos realizados,
                            produtos oferecidos, avaliações de clientes e contatos recebidos.
                        </p>

                        <div class="hero-meta-line">
                            <i class="far fa-check-circle"></i>
                            <?= (int)$totProjetos; ?> projetos, <?= (int)$totProdutos; ?> produtos,
                            <?= (int)$totAvaliacoes; ?> avaliações e <?= (int)$totContatos; ?> contatos registrados.
                        </div>

                        <?php if ($contatosNaoLidos > 0 || $contatosNaoResp > 0): ?>
                            <div class="hero-alert mt-3">
                                <i class="fas fa-envelope-open-text mr-1"></i>
                                <?php if ($contatosNaoLidos > 0): ?>
                                    <span><strong><?= $contatosNaoLidos; ?></strong> contato(s) para ler</span>
                                <?php endif; ?>
                                <?php if ($contatosNaoResp > 0): ?>
                                    <span class="ml-2"><strong><?= $contatosNaoResp; ?></strong> contato(s) para responder</span>
                                <?php endif; ?>
                                <span class="ml-2">•</span>
                                <a href="contatos.php" class="hero-alert-link">abrir contatos</a>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- LADO DIREITO: logo grande, só em telas grandes -->
                    <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                        <div class="hero-side-logo">
                            <img src="../img/logo_admin.png" alt="Ferriso Isolações Térmicas">
                        </div>
                    </div>

                </div>
            </div>


            <!-- CARDS: PROJETOS / PRODUTOS / AVALIAÇÕES / CONTATOS -->
            <div class="row summary-row">

                <!-- Projetos -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                    <div class="summary-card">
                        <div>
                            <div class="summary-card-header">
                                <div class="summary-icon">
                                    <i class="fas fa-hard-hat"></i>
                                </div>
                                <div>
                                    <div class="summary-title">Projetos</div>
                                    <div class="summary-subtitle">Portfólio de obras e serviços</div>
                                </div>
                            </div>

                            <div class="summary-number"><?= (int)$totProjetos; ?></div>
                            <div class="summary-footnote">
                                Itens marcados como ativos na listagem de projetos.
                            </div>
                        </div>
                        <div class="summary-footer">
                            <span>Cadastro, edição e destaque.</span>
                            <a href="projetos.php" class="btn-summary-link">
                                Abrir projetos <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Produtos -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                    <div class="summary-card">
                        <div>
                            <div class="summary-card-header">
                                <div class="summary-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div>
                                    <div class="summary-title">Produtos</div>
                                    <div class="summary-subtitle">Catálogo de isolamento térmico</div>
                                </div>
                            </div>

                            <div class="summary-number"><?= (int)$totProdutos; ?></div>
                            <div class="summary-footnote">
                                Produtos exibidos nas áreas de atuação e demais seções do site.
                            </div>
                        </div>
                        <div class="summary-footer">
                            <span>Imagens, descrições e destaques.</span>
                            <a href="produtos.php" class="btn-summary-link">
                                Abrir produtos <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Avaliações -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                    <div class="summary-card">
                        <div>
                            <div class="summary-card-header">
                                <div class="summary-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <div class="summary-title">Avaliações</div>
                                    <div class="summary-subtitle">Depoimentos de clientes</div>
                                </div>
                            </div>

                            <div class="summary-number"><?= (int)$totAvaliacoes; ?></div>
                            <div class="summary-footnote">
                                Avaliações publicadas na página inicial e em seções internas.
                            </div>
                        </div>
                        <div class="summary-footer">
                            <span>Controle de visibilidade e conteúdo.</span>
                            <a href="avaliacoes.php" class="btn-summary-link">
                                Abrir avaliações <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contatos -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                    <div class="summary-card">
                        <div>
                            <div class="summary-card-header">
                                <div class="summary-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <div class="summary-title">Contatos</div>
                                    <div class="summary-subtitle">Formulário do site</div>
                                </div>
                            </div>

                            <div class="summary-number"><?= (int)$totContatos; ?></div>
                            <div class="summary-footnote">
                                Registros enviados pelo formulário de contato do site.
                                <?php if ($contatosNaoLidos > 0 || $contatosNaoResp > 0): ?>
                                    <br>
                                    <?= $contatosNaoLidos; ?> para ler · <?= $contatosNaoResp; ?> para responder.
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <span>Acompanhamento de mensagens recebidas.</span>
                            <a href="contatos.php" class="btn-summary-link">
                                Abrir contatos <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>