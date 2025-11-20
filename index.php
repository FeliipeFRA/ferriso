<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// conexão
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/config.php';

// query dados area de atuacao
$stmt = $con->prepare("
  SELECT id, nome, resumo, capa_img
  FROM areas_atuacao
  WHERE destaque = 1
  ORDER BY nome ASC
");
$stmt->execute();
$res = $stmt->get_result();
$areas = $res->fetch_all(MYSQLI_ASSOC);

// query projetos
$stmtp = $con->prepare("
  SELECT id, titulo, cliente, localizacao, data_projeto, resumo, capa_img
  FROM projetos
  WHERE ativo = 1 AND destaque = 1
  ORDER BY titulo ASC
");
$stmtp->execute();
$resp = $stmtp->get_result();
$proj = $resp->fetch_all(MYSQLI_ASSOC);

// query produtos
$stmtpo = $con->prepare("
  SELECT id, nome, resumo, capa_img
  FROM produtos
  WHERE ativo = 1 AND destaque = 1
  ORDER BY nome ASC
");
$stmtpo->execute();
$respo = $stmtpo->get_result();
$prod = $respo->fetch_all(MYSQLI_ASSOC);

$active = 'home';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<?php require __DIR__ . '/partials/header.php'; ?>


<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1">
                <img class="img-fluid" src="img/carousel-1.png" alt="Image">
            </button>
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="1" aria-label="Slide 2">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="Image">
            </button>
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="2" aria-label="Slide 3">
                <img class="img-fluid" src="img/carousel-3.png" alt="Image">
            </button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="img/carousel-1.png" alt="Image">
                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-4 animated zoomIn">NÓS OFERECEMOS</h4>
                        <h1 class="display-1 text-white mb-0 animated zoomIn">Inovação com a Força da Experiência</h1>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-4 animated zoomIn">TRAZEMOS</h4>
                        <h1 class="display-1 text-white mb-0 animated zoomIn">Modernidade com a Solidez da Tradição</h1>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="img/carousel-3.png" alt="Image">
                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-4 animated zoomIn">CRESCEMOS COM</h4>
                        <h1 class="display-1 text-white mb-0 animated zoomIn">O Equilíbrio entre Tradição e Inovação</h1>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
</div>
<!-- Carousel End -->


<!-- Informacoes Start-->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="fact-item bg-light rounded text-center h-100 p-5">
                    <i class="fa fa-calendar fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Anos de Experiência</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">26</h1>
                </div>
            </div>
            <!-- ADICIONAR QUANDO EQUIPE FOR MAIOR

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="fact-item bg-light rounded text-center h-100 p-5">
                        <i class="fa fa-users-cog fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">Team Members</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up">1234</h1>
                    </div>
                </div>
                -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="fact-item bg-light rounded text-center h-100 p-5">
                    <i class="fa fa-users fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Clientes Satisfeitos</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">18</h1>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="fact-item bg-light rounded text-center h-100 p-5">
                    <i class="fa fa-check fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Projetos Realizados</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">57</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Informacoes End-->



<div class="container-xxl py-5">
    <!-- Sobre Start-->
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="img-border">
                    <img class="img-fluid" src="img/about.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
                    <h6 class="section-title bg-white text-start text-primary pe-3">SOBRE</h6>
                    <h1 class="display-6 mb-4">Experiência que <span class="text-primary">MODERNIZA</span> o Isolamento Térmico</h1>
                    <p>A Ferriso Isolamentos nasceu para ser a ponte entre a experiência de campo e o que há de mais atual em soluções de isolamento térmico. Embora recente como CNPJ, nossa base é formada por fundadores que há anos atuam no setor, acumulando projetos em diferentes segmentos e entendendo, na prática, o que funciona — e o que precisa evoluir.</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="/sobre.php">SAIBA MAIS</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Sobre End-->

    <!-- Diferenciais Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="h-100">
                        <h6 class="section-title bg-white text-start text-primary pe-3">POR QUE NOS ESCOLHER?</h6>
                        <h1 class="display-6 mb-4">Conheça Nossos Diferenciais!</h1>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="skill">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2"><strong>Experiência De Campo</strong></p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="skill">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2"><strong>Equipe Técnica Especializada</strong></p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="skill">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2"><strong>Compromisso Com Segurança</strong></p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="skill">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2"><strong>Planejamento E Cumprimento De Prazos</strong></p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="skill">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2"><strong>Atendimento Próximo E Flexível</strong></p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="img-border">
                        <img class="img-fluid" src="img/diferenciais.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Diferenciais End -->
</div>

<!-- Areas de Atuação Start-->
<?php if (!empty($areas)): ?>
    <div class="container-xxl py-5">

        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">ÁREAS DE ATUAÇÃO</h6>
                <h1 class="display-6 mb-4">Isolamento De Qualidade Para Diversos Setores</h1>
            </div>

            <div class="row g-4">

                <?php $delays = ['0.1s', '0.3s', '0.5s']; ?>
                <?php foreach ($areas as $idx => $a): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= htmlspecialchars($delays[$idx % 3]) ?>">
                        <div class="service-item d-block rounded text-center h-100 p-4">
                            <img
                                class="img-fluid rounded mb-4"
                                src="<?= htmlspecialchars(img_url($a['capa_img'])) ?>"
                                alt="<?= htmlspecialchars($a['nome']) ?>">
                            <h4 class="mb-0"><?= htmlspecialchars($a['nome']) ?></h4>
                            <p style="margin-top: 1rem;"><?= htmlspecialchars($a['resumo']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mx-auto mb-5 wow fadeInUp pt-5" data-wow-delay="0.1s" style="max-width: 600px;">
                <a class="btn btn-primary rounded-pill py-3 px-5" href="/areas.php">VEJA MAIS</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Areas de Atuação End-->

<!-- Project Start -->
<?php if (!empty($proj)): ?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">PORTIFÓLIO</h6>
                <h1 class="display-6 mb-4">Saiba Mais Sobre Nossos Projetos</h1>
            </div>
            <div class="owl-carousel project-carousel wow fadeInUp" data-wow-delay="0.1s">
                <?php foreach ($proj as $idx => $p): ?>
                    <div class="project-item border rounded h-100 p-4" data-dot="<?= htmlspecialchars($idx) ?>">
                        <div class="position-relative mb-4">
                            <img class="img-fluid rounded" src="img/project-1.jpg" alt="">
                            <a href="img/project-1.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                        </div>
                        <h6><?= htmlspecialchars($p['titulo']) ?></h6>
                        <span><?= htmlspecialchars($p['resumo']) ?></span><br>
                        <span><small><i class="fab fa-location-dot"></i> <?= htmlspecialchars($p['localizacao']) ?></small></span>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="text-center mx-auto mb-5 wow fadeInUp pt-5" data-wow-delay="0.1s" style="max-width: 600px;">
            <a class="btn btn-primary rounded-pill py-3 px-5" href="/projetoss.php">VEJA MAIS</a>
        </div>
    </div>
<?php endif; ?>
<!-- Project End -->


<!-- Produtos Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">NOSSOS PRODUTOS</h6>
            <h1 class="display-6 mb-4">Tudo Que Você Precisa Para Sua Obra</h1>
        </div>
        <div class="row g-4">

            <div class="owl-carousel project-carousel wow fadeInUp" data-wow-delay="0.1s">
                <?php foreach ($proj as $idx => $p): ?>
                    <div class="project-item border rounded h-100 p-4" data-dot="01">
                        <div class="position-relative mb-4">
                            <img class="img-fluid rounded" src="img/project-1.jpg" alt="">
                            <a href="img/project-1.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                        </div>
                        <h6><?= htmlspecialchars($p['titulo']) ?></h6>
                        <span><?= htmlspecialchars($p['resumo']) ?></span><br>
                        <span><small><i class="fab fa-location-dot"></i> <?= htmlspecialchars($p['localizacao']) ?></small></span>
                    </div>
                <?php endforeach; ?>

            </div>


            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item text-center p-4">
                    <img class="img-fluid border rounded-circle w-75 p-2 mb-4" src="img/team-1.jpg" alt="">
                    <div class="team-text">
                        <div class="team-title">
                            <h5>Full Name</h5>
                            <span>Designation</span>
                        </div>
                        <div class="team-social">
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="team-item text-center p-4">
                    <img class="img-fluid border rounded-circle w-75 p-2 mb-4" src="img/team-2.jpg" alt="">
                    <div class="team-text">
                        <div class="team-title">
                            <h5>Full Name</h5>
                            <span>Designation</span>
                        </div>
                        <div class="team-social">
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="team-item text-center p-4">
                    <img class="img-fluid border rounded-circle w-75 p-2 mb-4" src="img/team-3.jpg" alt="">
                    <div class="team-text">
                        <div class="team-title">
                            <h5>Full Name</h5>
                            <span>Designation</span>
                        </div>
                        <div class="team-social">
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Produtos End -->


<!-- Avaliações Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">AVALIAÇÕES</h6>
            <h1 class="display-6 mb-4">Feedbacks Dos Nossos Clientes!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
            <div class="testimonial-item bg-light rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-1.jpg" alt="">
                    <div class="ms-4">
                        <h5 class="mb-1">Client Name</h5>
                        <span>Profession</span>
                    </div>
                </div>
                <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
            </div>
            <div class="testimonial-item bg-light rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-2.jpg" alt="">
                    <div class="ms-4">
                        <h5 class="mb-1">Client Name</h5>
                        <span>Profession</span>
                    </div>
                </div>
                <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
            </div>
            <div class="testimonial-item bg-light rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-3.jpg" alt="">
                    <div class="ms-4">
                        <h5 class="mb-1">Client Name</h5>
                        <span>Profession</span>
                    </div>
                </div>
                <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
            </div>
            <div class="testimonial-item bg-light rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-4.jpg" alt="">
                    <div class="ms-4">
                        <h5 class="mb-1">Client Name</h5>
                        <span>Profession</span>
                    </div>
                </div>
                <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Testimonial End -->
<?php require __DIR__ . '/partials/footer.php'; ?>