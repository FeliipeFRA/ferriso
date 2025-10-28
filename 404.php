<?php 
// passa como resposta http o codigo 404
http_response_code(404); 
// evita indexação em mecanismos de pesquisa
header('X-Robots-Tag: noindex, nofollow');
?>

<?php 
$meta = ['title'=>'Página não encontrada', 'robots'=>'noindex'];
require __DIR__ . '/partials/header.php'; 
?>

    <!-- 404 Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                    <h1 class="display-1">404</h1>
                    <h1 class="mb-4">Página Não Encontrada</h1>
                    <p class="mb-4">O link pode estar incorreto ou a página foi removida.</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="index.php">Volte ao Ínicio</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 End -->
        
<?php require __DIR__ . '/partials/footer.php'; ?>