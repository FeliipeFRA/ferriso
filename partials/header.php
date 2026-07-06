<?php
// reports
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');

// variaveis
$active = $active ?? '';
$siteBaseUrl = 'https://ferrisoisolamentos.com.br';
$siteName = 'Ferriso Isolações Térmicas';
$siteShortName = 'Ferriso Isolamentos';
$siteDescription = 'Soluções de isolamento térmico industrial, revestimentos térmicos e materiais técnicos para obras, manutenção e eficiência energética em Barrinha, Ribeirão Preto e região.';
$siteKeywords = 'ferriso, ferriso isolamentos, ferriso isolações, isolamento térmico industrial, revestimento térmico, isolantes térmicos, Ribeirão Preto, Barrinha';

$pageMetaByActive = [
    'home' => [
        'title' => 'Ferriso Isolações Térmicas | Isolamento térmico industrial',
        'description' => $siteDescription,
        'path' => '/',
        'schema_type' => 'WebPage',
        'preload_image' => '/img/carousel-1.jpg',
    ],
    'sobre' => [
        'title' => 'Sobre a Ferriso | Experiência em isolamento térmico',
        'description' => 'Conheça a Ferriso Isolamentos, empresa de Barrinha/SP especializada em soluções de isolamento térmico com experiência de campo, segurança e acompanhamento próximo.',
        'path' => '/sobre',
        'schema_type' => 'AboutPage',
    ],
    'areas' => [
        'title' => 'Serviços de isolamento térmico industrial | Ferriso',
        'description' => 'Veja as áreas de atuação da Ferriso em isolamento térmico para indústrias, obras e manutenção, com foco em eficiência, segurança e durabilidade.',
        'path' => '/areas',
        'schema_type' => 'CollectionPage',
    ],
    'produtos' => [
        'title' => 'Produtos para isolamento térmico e revestimento | Ferriso',
        'description' => 'Conheça produtos técnicos para isolamento térmico, revestimentos metálicos, fixadores e acessórios para obras industriais e manutenção.',
        'path' => '/produtos',
        'schema_type' => 'CollectionPage',
    ],
    'portfolio' => [
        'title' => 'Portfólio de projetos de isolamento térmico | Ferriso',
        'description' => 'Confira projetos executados pela Ferriso em isolamento térmico, revestimentos e soluções sob medida para diferentes setores industriais.',
        'path' => '/portfolio',
        'schema_type' => 'CollectionPage',
    ],
    'avaliacoes' => [
        'title' => 'Avaliações de clientes | Ferriso Isolamentos',
        'description' => 'Leia feedbacks de clientes sobre projetos e soluções de isolamento térmico realizados pela Ferriso Isolamentos.',
        'path' => '/avaliacoes',
        'schema_type' => 'WebPage',
    ],
    'contato' => [
        'title' => 'Contato para orçamento de isolamento térmico | Ferriso',
        'description' => 'Fale com a Ferriso Isolamentos para solicitar orçamento, tirar dúvidas ou conversar sobre soluções de isolamento térmico para sua obra.',
        'path' => '/contato',
        'schema_type' => 'ContactPage',
    ],
    'privacidade' => [
        'title' => 'Política de Privacidade | Ferriso Isolamentos',
        'description' => 'Entenda como a Ferriso Isolamentos trata dados pessoais enviados pelo site, newsletter, formulários de contato, telefone e WhatsApp.',
        'path' => '/privacidade',
        'schema_type' => 'WebPage',
    ],
];

if (!function_exists('ferriso_absolute_url')) {
    function ferriso_absolute_url(string $path, string $baseUrl): string
    {
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}

$incomingMeta = (isset($meta) && is_array($meta)) ? $meta : [];
$defaultMeta = [
    'title' => $siteName,
    'description' => $siteDescription,
    'keywords' => $siteKeywords,
    'path' => '/',
    'image' => '/img/og-preview.jpg',
    'image_alt' => 'Ferriso Isolações Térmicas - isolamento térmico industrial',
    'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
    'schema_type' => 'WebPage',
];

$activeMeta = $pageMetaByActive[$active] ?? [];
$seoMeta = array_replace($defaultMeta, $activeMeta, $incomingMeta);
$seoTitle = trim($seoMeta['title']);
if (stripos($seoTitle, 'Ferriso') === false) {
    $seoTitle .= ' | ' . $siteName;
}

$canonicalUrl = $seoMeta['canonical'] ?? ferriso_absolute_url($seoMeta['path'], $siteBaseUrl);
$ogImageUrl = ferriso_absolute_url($seoMeta['image'], $siteBaseUrl);
$preloadImage = $seoMeta['preload_image'] ?? ($bannerImg ?? null);
$preloadImageUrl = $preloadImage ? ferriso_absolute_url($preloadImage, $siteBaseUrl) : null;
$scriptFile = $_SERVER['SCRIPT_FILENAME'] ?? __FILE__;
$updatedTime = is_readable($scriptFile) ? gmdate(DATE_ATOM, filemtime($scriptFile)) : gmdate(DATE_ATOM);

$schemaGraph = [];
if (stripos($seoMeta['robots'], 'noindex') === false) {
    $organizationId = $siteBaseUrl . '/#organization';
    $websiteId = $siteBaseUrl . '/#website';
    $webpageId = $canonicalUrl . '#webpage';

    $schemaGraph[] = [
        '@type' => 'LocalBusiness',
        '@id' => $organizationId,
        'name' => $siteName,
        'alternateName' => $siteShortName,
        'url' => $siteBaseUrl . '/',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => ferriso_absolute_url('/img/logo.png', $siteBaseUrl),
            'width' => 160,
            'height' => 50,
        ],
        'image' => $ogImageUrl,
        'description' => $siteDescription,
        'telephone' => '+55 16 99105-8025',
        'email' => 'contato@ferrisoisolamentos.com.br',
        'taxID' => '59.643.942/0001-30',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Barrinha',
            'addressRegion' => 'SP',
            'addressCountry' => 'BR',
        ],
        'areaServed' => [
            [
                '@type' => 'AdministrativeArea',
                'name' => 'Barrinha, SP',
            ],
            [
                '@type' => 'AdministrativeArea',
                'name' => 'Ribeirão Preto e região',
            ],
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '08:00',
                'closes' => '17:00',
            ],
        ],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => '+55 16 99105-8025',
            'contactType' => 'customer service',
            'areaServed' => 'BR',
            'availableLanguage' => 'Portuguese',
        ],
    ];

    $schemaGraph[] = [
        '@type' => 'WebSite',
        '@id' => $websiteId,
        'url' => $siteBaseUrl . '/',
        'name' => $siteName,
        'alternateName' => $siteShortName,
        'inLanguage' => 'pt-BR',
        'publisher' => ['@id' => $organizationId],
    ];

    $pageSchema = [
        '@type' => $seoMeta['schema_type'],
        '@id' => $webpageId,
        'url' => $canonicalUrl,
        'name' => $seoTitle,
        'description' => $seoMeta['description'],
        'isPartOf' => ['@id' => $websiteId],
        'about' => ['@id' => $organizationId],
        'primaryImageOfPage' => [
            '@type' => 'ImageObject',
            'url' => $ogImageUrl,
            'width' => 1200,
            'height' => 630,
        ],
        'inLanguage' => 'pt-BR',
        'dateModified' => $updatedTime,
    ];

    if ($active !== 'home' && !empty($seoMeta['path'])) {
        $breadcrumbId = $canonicalUrl . '#breadcrumb';
        $pageSchema['breadcrumb'] = ['@id' => $breadcrumbId];
        $schemaGraph[] = [
            '@type' => 'BreadcrumbList',
            '@id' => $breadcrumbId,
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Início',
                    'item' => $siteBaseUrl . '/',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => preg_replace('/\s+\|\s+.*$/', '', $seoTitle),
                    'item' => $canonicalUrl,
                ],
            ],
        ];
    }

    $schemaGraph[] = $pageSchema;

    if (in_array($active, ['home', 'areas'], true)) {
        $schemaGraph[] = [
            '@type' => 'Service',
            '@id' => $siteBaseUrl . '/areas#service',
            'name' => 'Isolamento térmico industrial',
            'serviceType' => 'Isolamento térmico, revestimento térmico e manutenção industrial',
            'description' => 'Serviços de isolamento térmico para indústrias e obras, com foco em eficiência energética, segurança e durabilidade.',
            'provider' => ['@id' => $organizationId],
            'areaServed' => 'Barrinha, Ribeirão Preto e região',
            'url' => $siteBaseUrl . '/areas',
        ];
    }
}
$schemaJson = $schemaGraph ? json_encode([
    '@context' => 'https://schema.org',
    '@graph' => $schemaGraph,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '';

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

$show_portfolio = $show_portfolio ?? true;
$show_avaliacoes = $show_avaliacoes ?? true;

try {
    if (isset($con) && $con instanceof mysqli) {
        // conta projetos ativos
        if ($res = $con->query("SELECT COUNT(*) AS total FROM projetos WHERE ativo = 1")) {
            $row = $res->fetch_assoc();
            $show_portfolio = ((int)$row['total'] > 0);
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
    $show_portfolio = true;
    $show_avaliacoes = true;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="author" content="Ferriso Isolamentos">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($seoMeta['description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($seoMeta['keywords'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="<?= htmlspecialchars($seoMeta['robots'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="googlebot" content="<?= htmlspecialchars($seoMeta['robots'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="theme-color" content="#002c53">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="alternate" hreflang="pt-BR" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Open Graph / Social Preview -->
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seoMeta['description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImageUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image:secure_url" content="<?= htmlspecialchars($ogImageUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?= htmlspecialchars($seoMeta['image_alt'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:updated_time" content="<?= htmlspecialchars($updatedTime, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($seoMeta['description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImageUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image:alt" content="<?= htmlspecialchars($seoMeta['image_alt'], ENT_QUOTES, 'UTF-8') ?>">
    <?php if ($preloadImageUrl): ?>
        <link rel="preload" as="image" href="<?= htmlspecialchars($preloadImageUrl, ENT_QUOTES, 'UTF-8') ?>" fetchpriority="high">
    <?php endif; ?>

    <!-- Favicon -->
    <link href="/img/favicon.ico" rel="icon">

    <?php if ($schemaJson): ?>
        <!-- Structured Data -->
        <script type="application/ld+json"><?= $schemaJson ?></script>
    <?php endif; ?>

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

    <!-- GTranslate: public language convenience widget -->
    <script>
        window.gtranslateSettings = {
            "default_language": "pt",
            "native_language_names": true,
            "languages": ["pt", "en", "es"],
            "wrapper_selector": ".gtranslate_wrapper",
            "flag_size": 24,
            "flag_style": "2d",
            "alt_flags": {
                "pt": "brazil",
                "en": "usa",
                "es": "mexico"
            }
        };
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/flags.js" defer></script>
</head>

<body>
    <!-- LOADING -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border spinner-gradient" role="status" style="width:6rem;height:6rem;"></div>
        <img src="/img/F.png" alt="" width="50" height="50" aria-hidden="true" class="position-absolute top-50 start-50 translate-middle" style="width: 50px; height: 50px;">
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
                <a href="/" class="navbar-brand m-0 p-0">
                    <img src="img/logo.png" alt="Ferriso Isolações Térmicas" width="160" height="50">
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
                <a href="/" class="nav-item nav-link <?= $active === 'home' ? 'active' : '' ?>">Início</a>
                <a href="/sobre" class="nav-item nav-link <?= $active === 'sobre' ? 'active' : '' ?>">Sobre</a>
                <?php if ($show_portfolio): ?>
                    <a href="/portfolio" class="nav-item nav-link <?= $active === 'portfolio' ? 'active' : '' ?>">Portfólio</a>
                <?php endif; ?>
                <a href="/areas" class="nav-item nav-link <?= $active === 'areas' ? 'active' : '' ?>">Serviços</a>
                <a href="/produtos" class="nav-item nav-link <?= $active === 'produtos' ? 'active' : '' ?>">Produtos</a>
                <?php if ($show_avaliacoes): ?>
                    <a href="/avaliacoes" class="nav-item nav-link <?= $active === 'avaliacoes' ? 'active' : '' ?>">Avaliações</a>
                <?php endif; ?>
                <!-- mobile -->
                <a href="/contato" class="nav-item nav-link d-block d-lg-none">Contato</a>
            </div>
            <!-- desktop -->
            <a href="/contato" class="btn btn-sm btn-light rounded-pill py-2 px-4 d-none d-lg-block">Contato</a>
            <div class="ferriso-language-switcher notranslate" translate="no" aria-label="Language selector">
                <span class="visually-hidden">Language selector</span>
                <div class="gtranslate_wrapper"></div>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
