<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// conexão
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/config.php';

$active    = "produtos";
$bannerImg = "img/headers/produtos.jpg";

// busca todos os produtos ativos
$stmt = $con->prepare("
    SELECT id, nome, categoria, slug, descricao, capa_img, preco
    FROM produtos
    WHERE ativo = 1
    ORDER BY nome ASC
");
$stmt->execute();
$res      = $stmt->get_result();
$produtos = $res->fetch_all(MYSQLI_ASSOC);

// mapeia categorias
$categorias_legenda = [
    'revestimento_metalico' => 'Revestimentos Metálicos',
    'isolantes_termicos'    => 'Isolantes Térmicos',
    'acessorios'  => 'Acessórios e Fixadores',
];

$grupos = [
    'revestimento_metalico' => [],
    'isolantes_termicos'    => [],
    'acessorios'  => [],
    'outros'                => [],
];

foreach ($produtos as $p) {
    $cat = $p['categoria'];
    if (isset($grupos[$cat])) {
        $grupos[$cat][] = $p;
    } else {
        $grupos['outros'][] = $p;
    }
}
?>

<?php require __DIR__ . '/partials/header.php'; ?>


<!-- Page Header -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn"
    data-wow-delay="0.1s"
    style="background:
              linear-gradient(rgba(0,44,83,.55), rgba(0,44,83,.55)),
              url('<?= htmlspecialchars($bannerImg) ?>') center center / cover no-repeat;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Produtos</h1>
    </div>
</div>
<!-- Page Header -->


<!-- Produtos por categoria -->
<div class="container-xxl py-5">
    <div class="container">

        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">PRODUTOS</h6>
            <h1 class="display-6 mb-4">Tudo Que Você Precisa Para Sua Obra</h1>
        </div>

        <?php
        $ordemCategorias = [
            'revestimento_metalico',
            'isolantes_termicos',
            'acessorios',
            'outros'
        ];
        ?>

        <?php foreach ($ordemCategorias as $catKey): ?>
            <?php
            $lista = $grupos[$catKey] ?? [];
            if (empty($lista)) continue;

            $titulo = $catKey === 'outros'
                ? 'Outros Produtos'
                : $categorias_legenda[$catKey];
            ?>

            <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="text-center mx-auto mb-4" style="max-width: 700px;">
                    <h1 class="display-6 mb-3 text-uppercase text-primary">
                        <?= htmlspecialchars($titulo) ?>
                    </h1>
                </div>

                <div class="owl-carousel Pprodutos-carousel wow fadeInUp" data-wow-delay="0.2s">
                    <?php foreach ($lista as $idx => $p): ?>
                        <?php
                        $assunto  = 'Solicitação de Orçamento - ' . $p['nome'];
                        $mensagem = "Olá, venho através do site institucional solicitar orçamento de item.\n"
                            . "Produto: {$p['nome']}\n"
                            . "Quantidade:\n"
                            . "Data de entrega desejada:\n"
                            . "Observações:\n";
                        $linkOrcamento = '/contato.php?assunto=' . urlencode($assunto)
                            . '&mensagem=' . urlencode($mensagem);
                        ?>
                        <div class="produto-item border rounded h-100 p-4 d-flex flex-column">
                            <div class="produto-thumb mb-3">
                                <img
                                    class="img-fluid rounded"
                                    src="<?= htmlspecialchars(img_url($p['capa_img'])) ?>"
                                    alt="<?= htmlspecialchars($p['nome']) ?>">
                            </div>
                            <h5 class="mb-2 text-center"><?= htmlspecialchars($p['nome']) ?></h5>
                            <p class="mb-3 text-center">
                                <?= nl2br(htmlspecialchars($p['descricao'])) ?>
                            </p>
                            <div class="mt-auto pt-2 text-center">
                                <a
                                    href="<?= htmlspecialchars($linkOrcamento) ?>"
                                    class="btn btn-primary rounded-pill py-2 px-4">
                                    Solicitar Orçamento
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>
<!-- Fim Produtos -->


<?php require __DIR__ . '/partials/footer.php'; ?>