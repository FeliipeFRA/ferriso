<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/guard.php';
guard_require();
$u = guard_user();

// id da página
$pag  = 'contatos';
$menu = 'contatos';

require_once __DIR__ . '/partials/nav.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Contatos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active">Contatos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-tools fa-3x text-muted mb-3"></i>

                            <h3 class="card-title mb-3">Funcionalidade em desenvolvimento</h3>

                            <p class="card-text">
                                Esta área do painel ainda está sendo desenvolvida.
                                Assim que estiver pronta, ficará disponível para uso aqui.
                            </p>

                            <a href="home.php" class="btn btn-primary mt-2">
                                Voltar para a Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once __DIR__ . '/partials/footer.php'; ?>
