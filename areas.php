<?php
$active = 'areas';
$bannerImg = "img/headers/areas.jpg";

// conexão
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/config.php';

// query dados area de atuacao pag
$stmt = $con->prepare("
  SELECT id, nome, resumo, capa_img
  FROM areas_atuacao
  WHERE ativo = 1
  ORDER BY nome ASC
");
$stmt->execute();
$res = $stmt->get_result();
$areas = $res->fetch_all(MYSQLI_ASSOC);
?>

<?php require __DIR__ . '/partials/header.php'; ?>

<!-- Page Header -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn"
    data-wow-delay="0.1s"
    style="background:
              linear-gradient(rgba(0,44,83,.55), rgba(0,44,83,.55)),
              url('<?= htmlspecialchars($bannerImg) ?>') center center / cover no-repeat;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Áreas De Atuação</h1>
    </div>
</div>
<!-- Page Header -->


<!-- Areas de Atuação Start-->
<?php if (!empty($areas)): ?>
    <div class="container-xxl py-5">

        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">Áreas De Atuação</h6>
                <h1 class="display-6 mb-4">Isolamento De Qualidade Para Diversos Setores</h1>
            </div>

            <div class="owl-carousel areas-carousel nav-sides wow fadeInUp" data-wow-delay="0.1s">
                <?php foreach ($areas as $a): ?>
                    <div class="service-item d-block rounded text-center h-100 p-4">
                        <img
                            class="img-fluid rounded mb-4"
                            src="<?= htmlspecialchars(img_url($a['capa_img'])) ?>"
                            alt="<?= htmlspecialchars($a['nome']) ?>">
                        <h4 class="mb-0"><?= htmlspecialchars($a['nome']) ?></h4>
                        <p style="margin-top: 1rem;"><?= htmlspecialchars($a['resumo']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Areas de Atuação End-->


<?php require __DIR__ . '/partials/footer.php'; ?>