<!-- Footer Start -->
<div class="container-fluid bg-dark text-body footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <h5 class="text-light mb-4 hover-vermelho">Informações</h5>
                <p class="mb-2">
                    <i class="fa fa-map-marker-alt me-3"></i>
                    <a href="https://www.google.com/maps/search/?api=1&query=Barrinha%2C%20S%C3%A3o%20Paulo" target="_blank" rel="noopener" class="text-reset text-decoration-none">
                        Barrinha, São Paulo
                    </a>
                </p>

                <p class="mb-2">
                    <i class="fa fa-phone-alt me-3"></i>
                    <a href="tel:+5516991058025" class="text-reset text-decoration-none">
                        (16) 99105-8025
                    </a>
                </p>

                <p class="mb-2">
                    <i class="fab fa-whatsapp me-3"></i>
                    <a href="https://wa.me/5516991058025?text=Ol%C3%A1%21%20Vim%20do%20site%20da%20Ferriso%20Isolamentos%20e%20gostaria%20de%20iniciar%20contato."
                        target="_blank" rel="noopener"
                        class="text-reset text-decoration-none">
                        (16) 99105-8025
                    </a>
                </p>


                <p class="mb-2">
                    <i class="fa fa-envelope me-3"></i>
                    <a
                        href="mailto:contato@ferrisoisolamentos.com.br?subject=Contato%20via%20site&body=Ol%C3%A1,%20vim%20do%20site%20da%20Ferriso%20Isolamentos%20e%20gostaria%20de%20iniciar%20contato."
                        target="_blank" rel="noopener"
                        class="text-reset text-decoration-none">
                        contato@ferrisoisolamentos.com.br
                    </a>
                </p>


                <!--
                REDES SOCIAIS (ADICIONAR QUANDO TIVER)
                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
                -->
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4 hover-vermelho">Links Rápidos</h5>
                <a class="btn btn-link" href="sobre.php">Sobre</a>
                <a class="btn btn-link" href="contato.php">Contato</a>
                <a class="btn btn-link" href="privacidade.php">Política de Privacidade</a>
                <a class="btn btn-link" href="admin/login.php">Painel Administrativo</a>
            </div>

            <!-- NewsLetter -->
            <div class="col-lg-4 col-md-6">
                <h5 class="text-light mb-4 hover-vermelho">Fique por dentro</h5>
                <p>Receba em seu e-mail informações das tendências do mercado de isolamento térmico.</p>

                <form id="newsletterForm" action="/newsletter/subscribe.php" method="post"
                    class="position-relative mx-auto" style="max-width: 400px;">
                    <label for="nl-email" class="visually-hidden">E-mail</label>
                    <input id="nl-email" name="email" type="email"
                        class="form-control bg-transparent border-secondary w-100 py-3 ps-4 pe-5"
                        placeholder="Informe seu e-mail" required>
                    <button type="submit" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                        Enviar
                    </button>

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="nl-consent" name="agree" required>
                        <label class="form-check-label text-light" for="nl-consent">
                            Concordo em receber e-mails da Ferriso. Li a
                            <a href="/privacidade.php" class="text-decoration-underline">Política de Privacidade</a>.
                        </label>
                    </div>
                </form>
            </div>
            <!-- NewsLetter -->

        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <a href="https://ferrisoisolamentos.com.br">Ferriso Isolações</a>, Todos os Direitos Reservados.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    Inovação com a Força da Experiência</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Modal NewsLetter -->
<div class="modal fade" id="nlModal" tabindex="-1" aria-labelledby="nlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nlModalLabel"><i class="fa fa-envelope me-3"></i> Newsletter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form     = document.getElementById('newsletterForm');
  const submitBt = form.querySelector('button[type="submit"]');
  const modalEl  = document.getElementById('nlModal');
  const modal    = new bootstrap.Modal(modalEl);
  const modalBody= modalEl.querySelector('.modal-body');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    submitBt.disabled = true;

    try {
      const fd = new FormData(form);
      const res = await fetch(form.action, { method: 'POST', body: fd });
      const msg = await res.text();

      modalBody.textContent = msg || (res.ok ? 'Solicitação processada.' : 'Não foi possível enviar.');
      modal.show();

      if (res.ok) form.reset();
    } catch (err) {
      modalBody.textContent = 'Falha de comunicação. Tente novamente.';
      modal.show();
    } finally {
      submitBt.disabled = false;
    }
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const params = new URLSearchParams(location.search);
  const nl = params.get('nl');
  if (!nl) return;

  const msgs = {
    confirmed: 'Inscrição confirmada! Obrigado por assinar nossa newsletter.',
    invalid:   'Link inválido ou já utilizado.',
    unsub:     'Você foi descadastrado com sucesso.'
  };

  if (msgs[nl]) {
    const modalEl   = document.getElementById('nlModal');
    const modalBody = modalEl.querySelector('.modal-body');
    modalBody.textContent = msgs[nl];
    new bootstrap.Modal(modalEl).show();

    // limpa o parâmetro da URL após exibir
    params.delete('nl');
    const clean = location.pathname + (location.hash || '');
    history.replaceState({}, '', clean);
  }
});
</script>
<!-- Modal NewsLetter -->



<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>

</html>