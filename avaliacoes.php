<?php
$active = "avaliacoes";
$bannerImg = "img/headers/avaliacoes.jpg"; 

// conexão
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/config.php';

// query avaliações pag
$stmta = $con->prepare("
  SELECT a.id, a.projeto_id, a.nome_cliente, a.empresa, a.titulo, a.comentario, a.criado_em,
         p.titulo AS projeto_titulo, p.capa_img AS projeto_img
  FROM avaliacoes a
  LEFT JOIN projetos p ON p.id = a.projeto_id
  WHERE a.ativo = 1
  ORDER BY a.criado_em DESC, a.id DESC
");
$stmta->execute();
$resa = $stmta->get_result();
$avaliacoes = $resa->fetch_all(MYSQLI_ASSOC);
?>

<?php require __DIR__ . '/partials/header.php'; ?>

<!-- Page Header -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn"
    data-wow-delay="0.1s"
    style="background:
              linear-gradient(rgba(0,44,83,.55), rgba(0,44,83,.55)),
              url('<?= htmlspecialchars($bannerImg) ?>') center center / cover no-repeat;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Avaliações</h1>
    </div>
</div>
<!-- Page Header -->


<!-- Avaliações Start -->
<?php if (!empty($avaliacoes)): ?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">AVALIAÇÕES</h6>
                <h1 class="display-6 mb-4">Feedbacks Dos Nossos Clientes</h1>
            </div>

            <div class="owl-carousel testimonial-carousel nav-sides wow fadeInUp" data-wow-delay="0.1s">
                <?php foreach ($avaliacoes as $av):
                    $avatar = !empty($av['projeto_img'])
                        ? img_url($av['projeto_img'])
                        : 'img/testimonial-default.jpg';
                ?>
                    <div class="testimonial-item bg-light rounded p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img class="flex-shrink-0 rounded-circle border p-1"
                                src="<?= htmlspecialchars($avatar) ?>"
                                alt="<?= htmlspecialchars($av['nome_cliente']) ?>">

                            <div class="ms-4">
                                <h5 class="mb-1"><?= htmlspecialchars($av['nome_cliente']) ?></h5>
                                <span><?= htmlspecialchars($av['empresa']) ?></span>
                            </div>
                        </div>

                        <?php if (!empty($av['titulo'])): ?>
                            <h6 class="mb-2"><?= htmlspecialchars($av['titulo']) ?></h6>
                        <?php endif; ?>

                        <p class="mb-0"><?= nl2br(htmlspecialchars($av['comentario'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Avaliações End -->

<?php require __DIR__ . '/partials/footer.php'; ?>