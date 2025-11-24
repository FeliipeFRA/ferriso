<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// mensagens da última submissão
$errors          = $_SESSION['contact_errors']  ?? [];
$old             = $_SESSION['contact_old']     ?? [];
$success_message = $_SESSION['contact_success'] ?? null;
unset($_SESSION['contact_errors'], $_SESSION['contact_old'], $_SESSION['contact_success']);

// valores iniciais dos campos (podem vir de sessão ou da URL)
$prefill_assunto  = $old['assunto']  ?? '';
$prefill_mensagem = $old['mensagem'] ?? '';

// se não veio nada da sessão, usa o que estiver na URL (?assunto=&mensagem=)
if ($prefill_assunto === '' && isset($_GET['assunto'])) {
    $prefill_assunto = mb_substr(trim($_GET['assunto']), 0, 150);
}
if ($prefill_mensagem === '' && isset($_GET['mensagem'])) {
    $prefill_mensagem = mb_substr(trim($_GET['mensagem']), 0, 2000);
}

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// dados da página
$active    = "contato";
$bannerImg = "img/headers/contato.jpg";
?>

<?php require __DIR__ . '/partials/header.php'; ?>

<!-- Page Header -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn"
    data-wow-delay="0.1s"
    style="background:
              linear-gradient(rgba(0,44,83,.55), rgba(0,44,83,.55)),
              url('<?= htmlspecialchars($bannerImg) ?>') center center / cover no-repeat;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Contato</h1>
    </div>
</div>
<!-- Page Header -->

<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">

        <div class="text-center mx-auto mb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Fale Conosco</h6>
            <h1 class="display-6 mb-3">Envie sua mensagem para a Ferriso Isolamentos</h1>
            <p class="mb-0">Preencha os campos abaixo e nossa equipe retornará o contato o mais breve possível.</p>
        </div>

        <?php if ($success_message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row g-0 justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.5s">
                <form action="/contato/contato_enviar.php" method="post" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                    <input type="hidden" name="origem" value="Site - Página de Contato">

                    <!-- honeypot anti-bot -->
                    <div style="display:none;">
                        <label>Não preencha este campo</label>
                        <input type="text" name="website" autocomplete="off">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="nome"
                                    name="nome"
                                    placeholder="Seu nome"
                                    required
                                    maxlength="120"
                                    value="<?= htmlspecialchars($old['nome'] ?? '') ?>">
                                <label for="nome">Seu nome *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Seu e-mail"
                                    required
                                    maxlength="150"
                                    value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                                <label for="email">Seu e-mail *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="tel"
                                    class="form-control"
                                    id="telefone"
                                    name="telefone"
                                    placeholder="(16) 99999-9999"
                                    maxlength="50"
                                    data-mask="phone"
                                    value="<?= htmlspecialchars($old['telefone'] ?? '') ?>">
                                <label for="telefone">Telefone / WhatsApp</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="assunto"
                                    name="assunto"
                                    placeholder="Assunto"
                                    maxlength="150"
                                    required
                                    value="<?= htmlspecialchars($prefill_assunto) ?>">
                                <label for="assunto">Assunto</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea
                                    class="form-control"
                                    placeholder="Escreva sua mensagem"
                                    id="mensagem"
                                    name="mensagem"
                                    style="height: 200px"
                                    required><?= htmlspecialchars($prefill_mensagem) ?></textarea>
                                <label for="mensagem">Mensagem *</label>
                            </div>
                        </div>

                        <!-- reCAPTCHA -->
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <div class="g-recaptcha" data-sitekey="6LfkHxcsAAAAABYes2PjIM-iubpuIv9fVMN6WOAT"></div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">
                                Enviar mensagem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->


<!-- Google Maps Start -->
<div class="container-xxl pt-5 px-0 wow fadeIn" data-wow-delay="0.1s">
    <iframe class="w-100 mb-n2" style="height: 450px;"
        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d215137.5357972604!2d-48.085099632693364!3d-21.19385152942496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1spt-BR!2sbr!4v1757015914132!5m2!1spt-BR!2sbr"
        frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>
<!-- Google Maps End -->

<!-- reCAPTCHA e máscara de telefone -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    document.addEventListener('input', function(e) {
        if (e.target.matches('input[data-mask="phone"]')) {
            let v = e.target.value.replace(/\D/g, '');

            if (v.length > 11) v = v.slice(0, 11);

            if (v.length > 6) {
                e.target.value = '(' + v.slice(0, 2) + ') ' + v.slice(2, 7) + '-' + v.slice(7);
            } else if (v.length > 2) {
                e.target.value = '(' + v.slice(0, 2) + ') ' + v.slice(2);
            } else if (v.length > 0) {
                e.target.value = '(' + v;
            } else {
                e.target.value = '';
            }
        }
    });
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>