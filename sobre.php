<?php
$active = 'sobre';
$bannerImg = "img/headers/produtos.jpg";
?>

<?php require __DIR__ . '/partials/header.php'; ?>

<!-- Page Header -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn"
    data-wow-delay="0.1s"
    style="background:
              linear-gradient(rgba(0,44,83,.55), rgba(0,44,83,.55)),
              url('<?= htmlspecialchars($bannerImg) ?>') center center / cover no-repeat;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Sobre Nós</h1>
    </div>
</div>
<!-- Page Header -->


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


<!-- Sobre Completo Start-->
<div class="container-xxl py-5">
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
                    <p class="mb-4">Surgimos com uma missão clara: modernizar e inovar o isolamento térmico, tornando-o mais eficiente, seguro e acessível. Isso significa especificações técnicas bem-feitas, escolha criteriosa de materiais, instalação com padrão de qualidade e acompanhamento próximo do início ao pós-obra. Trabalhamos com foco em desempenho energético, redução de perdas, longevidade das soluções e cumprimento rigoroso de prazos e normas.</p>
                    <p class="mb-4">Unimos método e atualização constante para entregar resultados consistentes: processos organizados, comunicação transparente e soluções sob medida para cada cliente. É assim que transformamos conhecimento acumulado em melhorias reais no dia a dia — com um olhar atual, sem abrir mão da solidez que só a prática oferece.</p>

                    <!--
                        <div class="d-flex align-items-center mb-4 pb-2">
                            <img class="flex-shrink-0 rounded-circle" src="img/team-1.jpg" alt="" style="width: 50px; height: 50px;">
                            <div class="ps-4">
                                <h6>Moço</h6>
                                <small>SEO & Founder</small>
                            </div>
                        </div>
                        -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sobre Completo End-->


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

<?php require __DIR__ . '/partials/footer.php'; ?>