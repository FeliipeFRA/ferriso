<?php require_once __DIR__ . '/config/php_init.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Ferriso Admin</title>

  <!-- Fonte (opcional) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
  <!-- Meta Tags -->
  <meta name="robots" content="noindex,nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 (necessário para spinner-border e utilitários) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <link href="../img/favicon.ico" rel="icon">

  <style>
    :root {
      /* Azul marinho */
      --navy-980: #000f1e;
      --navy-950: #001526;
      --navy-900: #001c2f;
      --navy-850: #00233d;
      --navy-800: #002c53;

      --primary: #2b77e5;
      --primary-hover: #2468c8;
      --text-100: #e7eef7;
      --text-300: #b2c3d9;

      --card-bg: rgba(255, 255, 255, .04);
      --input-bg: rgba(255, 255, 255, .03);

      --border: rgba(255, 255, 255, .12);
      --focus: 0 0 0 3px rgba(43, 119, 229, .35), 0 0 0 1px rgba(255, 255, 255, .18) inset;
      --radius: 14px;
      --shadow: 0 10px 24px rgba(0, 0, 0, .35), inset 0 1px 0 rgba(255, 255, 255, .03);

      /* fallback para o degradê do spinner */
      --vermelho-ferriso: #e53935;
    }

    * {
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
      color: var(--text-100);
      background:
        radial-gradient(1200px 600px at 15% 10%, #002c5355, transparent 60%),
        radial-gradient(900px 500px at 90% 70%, #001c2f66, transparent 60%),
        linear-gradient(180deg, var(--navy-900), var(--navy-980));
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    /* STACK centraliza LOGO + FORM e mantém distância mínima */
    .stack {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 6px;
      /* distância mínima */
    }

    /* Logo maior no mobile e MÉDIA, sempre colada no form */
    .logo-top img {
      width: clamp(180px, 48vw, 260px);
      height: auto;
      display: block;
      filter: drop-shadow(0 8px 22px rgba(0, 0, 0, .35));
    }

    /* Telas MÉDIAS: aumenta a logo */
    @media (min-width:576px) and (max-width:991.98px) {
      .stack {
        gap: 6px;
      }

      .logo-top img {
        width: clamp(220px, 34vw, 320px);
      }
    }

    /* Altura baixa: evita “vazar” verticalmente */
    @media (max-height:750px) {
      .logo-top img {
        width: clamp(140px, 22vh, 220px);
      }
    }

    .card {
      width: 100%;
      max-width: 460px;
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      overflow: hidden;
    }

    /* Telas MÉDIAS: diminui o form */
    @media (min-width:576px) and (max-width:991.98px) {
      .card {
        max-width: 400px;
      }

      .card__body {
        padding: 20px 24px 24px;
      }
    }

    .card__header {
      padding: 12px 28px 0;
      text-align: center;
    }

    .card__header h1 {
      margin: 0 0 4px;
      font-size: 1.75rem;
      font-weight: 600;
      letter-spacing: .2px;
    }

    .card__header small {
      color: var(--text-300);
    }

    .card__body {
      padding: 22px 28px 28px;
    }

    form {
      display: grid;
      gap: 16px;
    }

    .field {
      display: grid;
      gap: 8px;
    }

    label {
      font-size: .92rem;
      color: var(--text-300);
    }

    .control {
      position: relative;
      display: grid;
      align-items: center;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 14px 44px 14px 14px;
      color: var(--text-100);
      background: var(--input-bg);
      border: 1px solid var(--border);
      border-radius: 10px;
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
      font-size: 1rem;
    }

    input::placeholder {
      color: #8aa0bf;
    }

    input:focus {
      box-shadow: var(--focus);
      border-color: rgba(43, 119, 229, .6);
      background: rgba(255, 255, 255, .05);
    }

    .toggle-pass {
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      display: inline-grid;
      place-items: center;
      width: 36px;
      height: 36px;
      border: 0;
      background: transparent;
      color: #9fb3d1;
      border-radius: 8px;
      cursor: pointer;
    }

    .toggle-pass:hover {
      color: var(--text-100);
      background: rgba(255, 255, 255, .04);
    }

    .toggle-pass:focus-visible {
      outline: none;
      box-shadow: var(--focus);
    }

    .btn {
      width: 100%;
      padding: 14px 16px;
      border-radius: 10px;
      border: 0;
      background: var(--primary);
      color: #fff;
      font-weight: 600;
      letter-spacing: .2px;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .25);
      transition: background-color .15s, transform .06s;
    }

    .btn:hover {
      background: var(--primary-hover);
    }

    .btn:active {
      transform: translateY(1px);
    }

    .btn[disabled] {
      opacity: .75;
      cursor: not-allowed;
    }

    .btn__spinner {
      display: inline-block;
      width: 18px;
      height: 18px;
      border: 2px solid rgba(255, 255, 255, .35);
      border-top-color: #fff;
      border-radius: 50%;
      vertical-align: -3px;
      margin-right: 8px;
      animation: spin .8s linear infinite;
      visibility: hidden;
    }

    .btn.loading .btn__spinner {
      visibility: visible;
    }

    .hint {
      margin-top: 8px;
      text-align: center;
      color: var(--text-300);
      font-size: .9rem;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    a:focus-visible,
    button:focus-visible,
    input:focus-visible {
      outline: none;
      box-shadow: var(--focus);
    }

    /* ===================== Spinner/Overlay ===================== */
    /* do seu projeto, com fallback para --vermelho-ferriso */
    #spinner {
      opacity: 0;
      visibility: hidden;
      transition: opacity .5s ease-out, visibility 0s linear .5s;
      z-index: 99999;
    }

    #spinner.show {
      transition: opacity .5s ease-out, visibility 0s linear 0s;
      visibility: visible;
      opacity: 1;
    }

    .spinner-border.spinner-gradient {
      --ring-thickness: .35rem;
      border: 0 !important;
      border-radius: 50%;
      background: conic-gradient(var(--primary) 0 40%,
          var(--vermelho-ferriso, #e53935) 40% 80%,
          var(--primary) 80% 100%);
      -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - var(--ring-thickness)), #000 calc(100% - var(--ring-thickness)));
      mask: radial-gradient(farthest-side, transparent calc(100% - var(--ring-thickness)), #000 calc(100% - var(--ring-thickness)));
      animation: spinner-border .75s linear infinite;
    }

    @supports not (mask: radial-gradient(black, white)) {
      .spinner-border.spinner-gradient {
        border: var(--ring-thickness) solid var(--primary);
        border-right-color: transparent;
        background: none;
      }
    }

    @media (prefers-reduced-motion: reduce) {
      .spinner-border.spinner-gradient {
        animation-duration: 1.5s;
      }
    }

    /* Título branco e ícone alinhado */
    .card__header h1 {
      color: #fff;
    }

    .ico-admin {
      width: 22px;
      height: 22px;
      margin-right: 8px;
      vertical-align: -3px;
      display: inline-block;
      fill: currentColor;
    }

    /* Centralizar perfeitamente o texto do botão */
    .btn {
      display: inline-flex;
      /* passa a usar flex */
      align-items: center;
      justify-content: center;
    }

    /* O spinner do botão não ocupa espaço quando oculto */
    .btn__spinner {
      display: none;
      /* antes era visibility:hidden */
    }

    .btn.loading .btn__spinner {
      display: inline-block;
      margin-right: 8px;
      /* só aparece e cria espaçamento quando loading */
    }
  </style>
</head>

<body>


  <!-- CONJUNTO CENTRALIZADO (logo + form) -->
  <div class="stack">
    <div class="logo-top" aria-hidden="true">
      <img src="/img/logo_login.png" alt="Ferriso Isolações Térmicas">
    </div>

    <main class="card" role="main" aria-labelledby="titulo-login">
      <header class="card__header">
        <h1 id="titulo-login">
          <!-- Ícone admin (escudo com check) -->
          <svg class="ico-admin" viewBox="0 0 24 24" role="img" aria-label="Admin">
            <path
              d="M12 1.5l7.5 3v6c0 5.25-3.3 9.75-7.5 10.5C7.8 20.25 4.5 15.75 4.5 10.5v-6L12 1.5zM11 14.25l4.5-4.5-1.06-1.06L11 12.13l-1.94-1.94-1.06 1.06L11 14.25z" />
          </svg>
          Painel Administrativo
        </h1>
        <small>Acesso restrito</small>
      </header>

      <section class="card__body">
        <form id="loginForm" action="/admin/config/auth_login.php" method="post" novalidate>
          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES); ?>">

          <div class="field">
            <label for="usuario">Usuário</label>
            <div class="control">
              <input id="usuario" name="usuario" type="text" placeholder="seu usuário"
                autocomplete="username" required />
            </div>
          </div>

          <div class="field">
            <label for="password">Senha</label>
            <div class="control">
              <input id="password" name="password" type="password" placeholder="••••••••"
                autocomplete="current-password" required />
              <!-- seu botão de mostrar/ocultar senha pode ficar aqui -->
            </div>
          </div>

          <button id="btnSubmit" class="btn" type="submit">
            <span class="btn__spinner" aria-hidden="true"></span>
            Entrar
          </button>

          <div class="hint">Inovação com a Força da Experiência</div>
        </form>


      </section>
    </main>
  </div>

  <script>
    // Mostrar/ocultar senha
    (function() {
      const btn = document.querySelector('.toggle-pass');
      const pwd = document.getElementById('password');
      const eye = btn.querySelector('.icon-eye');
      const eyeOff = btn.querySelector('.icon-eye-off');
      btn.addEventListener('click', () => {
        const show = pwd.type === 'password';
        pwd.type = show ? 'text' : 'password';
        btn.setAttribute('aria-pressed', String(show));
        eye.style.display = show ? 'none' : '';
        eyeOff.style.display = show ? '' : 'none';
        pwd.focus();
      });
    })();

    // Estado de carregando ao enviar
    (function() {
      const form = document.querySelector('form');
      const btn = document.getElementById('btnSubmit');
      form.addEventListener('submit', () => {
        btn.classList.add('loading');
        btn.setAttribute('disabled', 'disabled');
      });
    })();

    // Oculta o overlay do spinner quando a página terminar de carregar
    window.addEventListener('load', function() {
      const sp = document.getElementById('spinner');
      if (sp) sp.classList.remove('show');
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function() {
      const form = document.getElementById('loginForm');
      const btn = document.getElementById('btnSubmit');

      function showMsg(text) {
        document.getElementById('msgText').textContent = text;
        const m = new bootstrap.Modal(document.getElementById('msgModal'));
        m.show();
      }

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        btn.classList.add('loading');
        btn.disabled = true;

        try {
          const resp = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json'
            }
          });
          const data = await resp.json();
          if (data.ok) {
            window.location.href = data.redirect || '/admin/layout.php';
          } else {
            showMsg(data.error || 'Falha ao entrar.');
          }
        } catch (err) {
          showMsg('Erro de conexão. Tente novamente.');
        } finally {
          btn.classList.remove('loading');
          btn.disabled = false;
        }
      });
    })();
  </script>


  <div class="modal fade" id="msgModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background:#0f1724;color:#fff">
        <div class="modal-header">
          <h5 class="modal-title">Aviso</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p id="msgText" class="mb-0"></p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-light" data-bs-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>