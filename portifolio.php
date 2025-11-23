<?php
$active = "portifolio";
$bannerImg = "img/headers/portifolio.jpg";

// conexão
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/config.php';

// query projetos home
$stmtp = $con->prepare("
  SELECT id, titulo, cliente, localizacao, data_projeto, resumo, capa_img
  FROM projetos
  WHERE ativo = 1
  ORDER BY titulo ASC
");
$stmtp->execute();
$resp = $stmtp->get_result();
$proj = $resp->fetch_all(MYSQLI_ASSOC);

?>

<?php require __DIR__ . '/partials/header.php'; ?>

<!-- Page Header -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn"
    data-wow-delay="0.1s"
    style="background:
              linear-gradient(rgba(0,44,83,.55), rgba(0,44,83,.55)),
              url('<?= htmlspecialchars($bannerImg) ?>') center center / cover no-repeat;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Portifólio</h1>
    </div>
</div>
<!-- Page Header -->


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
                    <div class="project-item border rounded h-100 p-4" data-dot="<?= htmlspecialchars($idx + 1) ?>">
                        <div class="position-relative mb-4">
                            <img class="img-fluid rounded" src="<?= htmlspecialchars(img_url($p['capa_img'])) ?>" alt="<?= htmlspecialchars($p['titulo']) ?>">
                            <a href="<?= htmlspecialchars(img_url($p['capa_img'])) ?>" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                        </div>
                        <h6><?= htmlspecialchars($p['titulo']) ?></h6>
                        <span><?= htmlspecialchars($p['resumo']) ?></span><br>
                        <div class="pt-2">
                            <span><small><strong><i class="fa fa-user"></i> <?= htmlspecialchars($p['cliente']) ?></strong></small></span><br>
                            <span><small><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($p['localizacao']) ?></small></span>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Project End -->


<!-- Testimonial Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
            <h1 class="display-6 mb-4">What Our Clients Say!</h1>
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
<!-- Testimonial End -->

<?php require __DIR__ . '/partials/footer.php'; ?>