<?php
$active = "privacidade"; 
$bannerImg = "img/headers/privacidade.png"; 
?>

<?php require __DIR__ . '/partials/header.php'; ?>

<!-- Page Header -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn"
     data-wow-delay="0.1s"
     style="background:
              linear-gradient(rgba(0,44,83,.55), rgba(0,44,83,.55)),
              url('<?= htmlspecialchars($bannerImg) ?>') center center / cover no-repeat;">
  <div class="container text-center py-5">
    <h1 class="display-4 text-white animated slideInDown mb-3">Política de Privacidade</h1>
  </div>
</div>
<!-- Page Header -->

<!-- Privacidade -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="mb-4">
      <p class="mb-2">Última atualização: <?php echo date('d/m/Y'); ?></p>
      <p>Esta Política descreve como a <strong>Ferriso Isolações</strong> (“Controlador”) trata dados pessoais em seu site.</p>
    </div>

    <h2 class="h4 mt-4" id="controlador">1. Controlador e contato</h2>
    <p class="mb-2">
      <strong>Ferriso Isolações</strong><br>
      <!-- Substitua pelo CNPJ/endereço oficiais -->
      CNPJ: 59.643.942/0001-30 • Barrinha/SP<br>
      E-mail do contato de privacidade: <a href="mailto:contato@ferrisoisolamentos.com.br">contato@ferrisoisolamentos.com.br</a>
    </p>

    <h2 class="h4 mt-4" id="dados">2. Quais dados tratamos</h2>
    <ul>
      <li><strong>Newsletter:</strong> e-mail informado voluntariamente no formulário de assinatura.</li>
      <li><strong>Contato:</strong> dados enviados por você via formulários, e-mails, telefone ou WhatsApp.</li>
      <li><strong>Navegação essencial:</strong> informações técnicas mínimas para funcionamento do site (logs e cookies estritamente necessários).</li>
    </ul>

    <h2 class="h4 mt-4" id="finalidades">3. Finalidades e bases legais</h2>
    <ul>
      <li><strong>Enviar newsletter</strong> – base legal: <em>consentimento</em> (art. 7º, I). Você pode cancelar a qualquer momento.</li>
      <li><strong>Responder solicitações</strong> (orçamentos/contatos) – base legal: <em>procedimentos preliminares/execução de contrato</em> (art. 7º, V).</li>
      <li><strong>Operar e proteger o site</strong> (segurança, prevenção a fraudes) – base legal: <em>legítimo interesse</em> (art. 7º, IX), com impacto mínimo ao titular.</li>
    </ul>

    <h2 class="h4 mt-4" id="compartilhamento">4. Compartilhamento</h2>
    <p>Não vendemos dados pessoais. Podemos compartilhar com provedores que prestam serviços ao site (hospedagem, e-mail transacional). Links/integrações de terceiros (ex.: Google Maps, WhatsApp) são regidos pelas políticas desses provedores.</p>

    <h2 class="h4 mt-4" id="retencao">5. Retenção</h2>
    <ul>
      <li><strong>Newsletter:</strong> mantemos o e-mail até o descadastro (opt-out).</li>
      <li><strong>Contatos:</strong> mantemos pelo tempo necessário ao atendimento e obrigações legais (ex.: até 12 meses). <!-- ajuste o prazo, se desejar --></li>
    </ul>

    <h2 class="h4 mt-4" id="direitos">6. Seus direitos (LGPD)</h2>
    <p>Você pode solicitar: confirmação e acesso; correção; anonimização/eliminação; portabilidade; informação sobre compartilhamentos; revogação do consentimento; e revisão de decisões automatizadas, quando aplicável. Para exercer, escreva para <a href="mailto:contato@ferrisoisolamentos.com.br">contato@ferrisoisolamentos.com.br</a>. Você também pode reclamar à ANPD.</p>

    <h2 class="h4 mt-4" id="cookies">7. Cookies</h2>
    <p>Utilizamos cookies <strong>estritamente necessários</strong> ao funcionamento do site. No momento, não usamos cookies de marketing. Caso passemos a usar cookies adicionais (ex.: analytics), atualizaremos esta Política e, quando necessário, solicitaremos seu consentimento.</p>

    <h2 class="h4 mt-4" id="seguranca">8. Segurança e transferências</h2>
    <p>Adotamos medidas técnicas e organizacionais proporcionais (ex.: TLS/HTTPS, controles de acesso). Fornecedores podem estar no Brasil ou no exterior; adotamos salvaguardas adequadas quando houver transferência internacional.</p>

    <h2 class="h4 mt-4" id="menores">9. Crianças e adolescentes</h2>
    <p>O site não é direcionado a menores. Caso identifiquemos dados de menor tratados sem a devida autorização, eliminaremos mediante solicitação.</p>

    <h2 class="h4 mt-4" id="atualizacoes">10. Atualizações desta Política</h2>
    <p>Podemos atualizar este documento para refletir melhorias do site ou exigências legais. A versão vigente é a desta página.</p>

    <hr class="my-4">

    <p class="small text-muted">
      Dúvidas sobre privacidade? Fale com a gente em
      <a href="mailto:contato@ferrisoisolamentos.com.br">contato@ferrisoisolamentos.com.br</a>.
    </p>
  </div>
</div>
<!-- Privacidade -->

<?php require __DIR__ . '/partials/footer.php'; ?>
