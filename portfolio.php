<?php
$active = "portfolio";
$bannerImg = "img/headers/portfolio.jpg";

// conexão
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/config.php';

// query projetos home
$stmtp = $con->prepare("
  SELECT id, titulo, cliente, localizacao, data_projeto, descricao, capa_img
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
        <h1 class="display-4 text-white animated slideInDown mb-3">Portfólio</h1>
    </div>
</div>
<!-- Page Header -->


<!-- Project Start -->
<?php if (!empty($proj)): ?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">PORTFÓLIO</h6>
                <h1 class="display-6 mb-4">Saiba Mais Sobre Nossos Projetos</h1>
            </div>

            <?php foreach ($proj as $idx => $p):
                // alterna lado no desktop
                $imgOrder  = ($idx % 2 === 0) ? '' : 'order-lg-2';
                $textOrder = ($idx % 2 === 0) ? '' : 'order-lg-1';
            ?>
                <div class="row g-5 align-items-center project-row mb-5">

                    <!-- IMAGEM -->
                    <div class="col-lg-6 <?= $imgOrder ?> wow fadeInUp" data-wow-delay="0.1s">
                        <div class="img-border project-img">
                            <a href="<?= htmlspecialchars(img_url($p['capa_img'])) ?>" data-lightbox="project-<?= (int)$p['id'] ?>">
                                <img class="img-fluid"
                                    src="<?= htmlspecialchars(img_url($p['capa_img'])) ?>"
                                    alt="<?= htmlspecialchars($p['titulo']) ?>">
                            </a>
                        </div>
                    </div>

                    <!-- TEXTO -->
                    <div class="col-lg-6 <?= $textOrder ?> wow fadeInUp" data-wow-delay="0.3s">
                        <div class="h-100 d-flex flex-column">
                            <h6 class="section-title bg-white text-start text-primary">PROJETO</h6>
                            <h1 class="display-6 mb-3"><?= htmlspecialchars($p['titulo']) ?></h1>

                            <p class="mb-4"><?= $p['descricao'] ?></p>

                            <div class="project-meta mt-auto">
                                <p class="mb-1">
                                    <small><strong><i class="fa fa-user"></i> <?= htmlspecialchars($p['cliente']) ?></strong></small>
                                </p>
                                <p class="mb-1">
                                    <small><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($p['localizacao']) ?></small>
                                </p>
                                <?php if (!empty($p['data_projeto'])): ?>
                                    <p class="mb-0">
                                        <small><i class="fa fa-calendar"></i> <?= htmlspecialchars(date('m/Y', strtotime($p['data_projeto']))) ?></small>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>


        </div>
    </div>
<?php endif; ?>
<!-- Project End -->


<?php require __DIR__ . '/partials/footer.php'; ?>