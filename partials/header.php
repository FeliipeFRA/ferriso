<?php
// reports
error_reporting(E_ALL);
ini_set('display_errors', 1);

// variaveis
$active = $active ?? '';

// garante conexão com o banco, se ainda não existir
if (!isset($con)) {
    $dbPath = __DIR__ . '/../config/db.php';
    $cfgPath = __DIR__ . '/../config/config.php';

    if (file_exists($cfgPath)) {
        require_once $cfgPath;
    }
    if (file_exists($dbPath)) {
        require_once $dbPath;
    }
}

try {
    if (isset($con) && $con instanceof mysqli) {
        // conta projetos ativos
        if ($res = $con->query("SELECT COUNT(*) AS total FROM projetos WHERE ativo = 1")) {
            $row = $res->fetch_assoc();
            $show_portifolio = ((int)$row['total'] > 0);
            $res->free();
        }

        // conta avaliações ativas
        if ($res2 = $con->query("SELECT COUNT(*) AS total FROM avaliacoes WHERE ativo = 1")) {
            $row2 = $res2->fetch_assoc();
            $show_avaliacoes = ((int)$row2['total'] > 0);
            $res2->free();
        }
    }
} catch (Throwable $e) {
    // em caso de erro de conexão/consulta, não esconde nada
    $show_portifolio = true;
    $show_avaliacoes = true;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>Ferriso - Isolações Térmicas</title>
    <meta name="author" content="HTML Codex">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Meta Tags -->
    <meta name="description" content="Soluções de isolamento térmico para indústrias e obras, com equipe experiente, qualidade certificada e entrega ágil em Ribeirão Preto e região.">
    <meta name="keywords" content="ferriso, ferriso isolamentos, ferriso isolações, ferriso isolacoes, isolacoes, isolamento térmico, revestimento térmico, Ribeirão Preto, barrinha, isolamento barrinha">
    <link rel="canonical" href="https://ferrisoisolamentos.com.br" />
    <link rel="manifest" href="site.webmanifest">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Infos Google Search -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "url": "https://www.ferrisoisolamentos.com.br",
            "name": "Ferriso Isolamentos",
            "alternateName": "Ferriso"
        }
    </script>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NV11WS86B9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-NV11WS86B9');
    </script>
</head>

<body>
    <!-- LOADING -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border spinner-gradient" role="status" style="width:6rem;height:6rem;"></div>
        <img src="/img/F.png" alt="Carregando..." class="position-absolute top-50 start-50 translate-middle" style="width: 50px; height: 50px;">
    </div>
    <!-- FIM DO LOADING -->


    <!-- REDES SOCIAIS E TERMOS, ADICIONAR DEPOIS-->
    <!--
    <div class="container-fluid bg-light px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Career</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Terms</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Privacy</a></li>
                </ol>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Nos siga nas redes:</small>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn-square text-primary border-end rounded-0" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn-square text-primary border-end rounded-0" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn-square text-primary border-end rounded-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn-square text-primary pe-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    -->


    <!-- INFOS BÁSICAS -->
    <div class="container-fluid py-4 px-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="row align-items-center top-bar">
            <!-- Logo: ocupa 12 no mobile, 3 no lg -->
            <div class="col-12 col-lg-3 text-center text-lg-start">
                <a href="index.php" class="navbar-brand m-0 p-0">
                    <img src="img/logo.png" alt="Logo">
                </a>
            </div>

            <!-- Info: 12 no mobile, 9 no lg -->
            <div class="col-12 col-lg-9 d-none d-lg-block">
                <div class="row gx-4 gy-2">
                    <!-- No LG: 2 colunas (6+6). No XL: 3 colunas (4+2+5) -->
                    <div class="col-lg-6 col-xl-4">
                        <div class="d-flex align-items-center justify-content-start gap-2 gap-xl-3">
                            <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                                <i class="far fa-clock text-primary"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="mb-1 d-none d-xl-block">Horário:</p>
                                <h6 class="mb-0 text-truncate">Seg - Sex, 8:00 - 17:00</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3">
                        <div class="d-flex align-items-center justify-content-start gap-2 gap-xl-3">
                            <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                                <i class="fa fa-phone text-primary"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="mb-1 d-none d-xl-block">Telefone:</p>
                                <h6 class="mb-0 text-truncate">(16) 99105-8025</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-5">
                        <div class="d-flex align-items-center justify-content-start gap-2 gap-xl-3">
                            <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                                <i class="far fa-envelope text-primary"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="mb-1 d-none d-xl-block">Email:</p>
                                <h6 class="mb-0 text-truncate" title="contato@ferrisoisolamentos.com.br">
                                    contato@ferrisoisolamentos.com.br
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark sticky-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="#" class="navbar-brand ms-3 d-lg-none">MENU</a>
        <button type="button" class="navbar-toggler me-3" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto p-3 p-lg-0">
                <a href="index.php" class="nav-item nav-link <?= $active === 'home' ? 'active' : '' ?>">Início</a>
                <a href="sobre.php" class="nav-item nav-link <?= $active === 'sobre' ? 'active' : '' ?>">Sobre</a>
                <?php if ($show_portifolio): ?>
                    <a href="portifolio.php" class="nav-item nav-link <?= $active === 'portifolio' ? 'active' : '' ?>">Portifólio</a>
                <?php endif; ?>
                <a href="areas.php" class="nav-item nav-link <?= $active === 'areas' ? 'active' : '' ?>">Serviços</a>
                <a href="produtos.php" class="nav-item nav-link <?= $active === 'produtos' ? 'active' : '' ?>">Produtos</a>
                <?php if ($show_avaliacoes): ?>
                    <a href="avaliacoes.php" class="nav-item nav-link <?= $active === 'avaliacoes' ? 'active' : '' ?>">Avaliações</a>
                <?php endif; ?>
                <!-- mobile -->
                <a href="contato.php" class="nav-item nav-link d-block d-lg-none">Contato</a>
            </div>
            <!-- desktop -->
            <a href="contato.php" class="btn btn-sm btn-light rounded-pill py-2 px-4 d-none d-lg-block">Contato</a>
        </div>
    </nav>
    <!-- Navbar -->