# Migracao Hostinger -> HostGator

Objetivo: migrar `ferrisoisolamentos.com.br` de forma segura, validada e reversivel, sem excluir nada da Hostinger e sem trocar DNS antes dos testes no ambiente novo.

## Status atual

- Fase: DNS do site ja apontado para HostGator e HTTP real funcionando; pendente acesso ao cPanel/Portal HostGator para AutoSSL, HTTPS final, e-mails e decisao sobre cron.
- Acao destrutiva executada: apenas limpeza no `public_html` novo da HostGator: ZIP temporario de upload e `default.html` padrao removidos apos extracao.
- DNS alterado: sim, em 2026-06-14.
- Backup criado por mim: sim, salvo fora do repositorio em `C:\Users\Michael Scott\Documents\Ferriso_migracao_backups`.
- Hospedagem antiga cancelada: nao deve ser cancelada ate validacao final.
- Ultima conferencia operacional: 2026-06-14, incluindo testes HTTP por `curl --resolve`.

## Achados confirmados localmente

- Tipo do site: PHP proprio, nao WordPress e nao Laravel.
- Banco: MySQL/MariaDB via `mysqli`.
- Public root confirmado: `public_html`.
- Fonte de arquivos para migracao: repositorio local `C:\Users\Michael Scott\Documents\GitHub\ferriso`, validado pelo usuario como equivalente aos arquivos do hPanel.
- Tamanho local aproximado: 2548 arquivos, 128.43 MB, sem contar `.git`.
- Arquivos principais:
  - `index.php`
  - `sobre.php`
  - `portfolio.php`
  - `areas.php`
  - `produtos.php`
  - `avaliacoes.php`
  - `contato.php`
  - `admin/`
  - `config/`
  - `.htaccess`
  - `robots.txt`
  - `sitemap.xml`
- Dependencias PHP provaveis:
  - PHP 8.0 ou superior, pois o codigo usa `str_starts_with`.
  - Extensoes/funcoes: `mysqli`, `mbstring`, `json`, `session`, `openssl`/`random_bytes`, `mail`, `file_get_contents` com acesso HTTPS para reCAPTCHA.
- Sintaxe PHP local: nao validada nesta maquina porque `php` nao esta disponivel no PATH; runtime HostGator validado por paginas e endpoints PHP.

## Etapa 1 - Levantamento Hostinger

Achados confirmados em leitura no hPanel:

- Pasta publica real do dominio: `public_html`.
- Estrutura vista no File Browser especifico do site: raiz com `public_html/` e `DO_NOT_UPLOAD_HERE`; `public_html/` aparece vazio.
- Fonte aprovada para os arquivos do site: repositorio local `C:\Users\Michael Scott\Documents\GitHub\ferriso`.
- Estado publico do dominio no momento da conferencia: `https://ferrisoisolamentos.com.br/` retorna HTTP 403.
- Versao PHP ativa: PHP 8.2.
- Extensoes necessarias confirmadas como marcadas/ativas: `curl`, `json`, `openssl`, `session`, `mbstring`, `mysqlnd`, `nd_mysqli`, `gd`, `zip`, `opcache`.
- Opcao PHP `allow_url_fopen`: ativa no hPanel como `allowUrlFopen`.
- Banco MySQL associado ao site: `u374171611_bd_ferriso`, tamanho exibido 1 MB, criado em 2025-08-25.
- Usuario MySQL associado: `u374171611_adminferriso`.
- Subdominios: nenhum subdominio existente apareceu; tela mostra apenas formulario de criacao.
- Redirecionamentos no hPanel: nenhum redirecionamento existente apareceu; tela mostra apenas formulario de criacao.
- Cron jobs: existe 1 cron job configurado em `0 3 * * *`. O comando usa uma URL externa com parametro `secret`; nao transcrever o segredo e considerar rotacao antes/depois da migracao.
- SSL: `Lifetime SSL`, status `Ativo`, criado em 2025-08-11, expira em `Nunca`.
- Paginas de erro: existem entradas padrao para 400, 401, 403, 404 e 500.
- Regras extras verificadas no hPanel: diretorios protegidos por senha, protecao hotlink, gerenciador de IP e gerenciador de indice de pastas mostraram telas de configuracao, sem lista clara de regras existentes.
- DNS no hPanel confirma registros de e-mail: MX para `mx.uhserver.com`, SPF `include:spf.whservidor.com`, alem de CNAMEs `mail`, `webmail`, `imap`, `pop`, `pop3`, `smtp` e DKIM `pro._domainkey`.
- Contas de e-mail: nao confirmadas no hPanel; a area `E-mails` abriu como tela de contratacao de plano, nao como lista de caixas. Como ha MX e registros de e-mail no DNS, confirmar as caixas em outro painel/provedor antes da troca.

Observacao importante: o File Browser do dominio mostra `public_html` vazio e o dominio publico retorna 403. O usuario confirmou que os arquivos podem ser os do repositorio local e que eles correspondem ao que deve ser usado na migracao.

## Etapa 2 - Backup completo

Backups locais criados/validados:

- Pasta local de backup: `C:\Users\Michael Scott\Documents\Ferriso_migracao_backups\20260611-221918`.
- Backup de arquivos: `ferriso-site-files.zip`.
  - Tamanho: 42.418.942 bytes.
  - SHA256: `64CF9E3E222EF6C9571E791DB3255A3D664AEE4AD8367790BFBF22115ED2764F`.
  - Validacao: o ZIP abriu corretamente e contem 2586 entradas.
  - Arquivos essenciais confirmados dentro do ZIP: `index.php`, `.htaccess`, `config/db.php`, `config/config.php`, `contato/contato_enviar.php`, `admin/ferriso_api.php`, `newsletter/subscribe.php`.
- Dump SQL: `u374171611_bd_ferriso.sql`.
  - Origem: `C:\Users\Michael Scott\Downloads\u374171611_bd_ferriso.sql`.
  - Copia no backup: `C:\Users\Michael Scott\Documents\Ferriso_migracao_backups\20260611-221918\u374171611_bd_ferriso.sql`.
  - Tamanho: 23.897 bytes.
  - Linhas: 348.
  - SHA256: `1504ACD5E6DC32DAC9D69262BFB9300D38DA38224A6ED491583AB7562CD93F53`.
  - Validacao: nao esta vazio, contem `CREATE TABLE`, `INSERT INTO`, `COMMIT` e assinatura de exportacao phpMyAdmin.
  - Tabelas encontradas: `areas_atuacao`, `avaliacoes`, `contatos`, `newsletter_subscribers`, `produtos`, `projetos`, `usuarios`.
- Export DNS: `ferrisoisolamentos.com.br-dns-export.txt`.
  - Origem: `C:\Users\Michael Scott\Downloads\ferrisoisolamentos.com.br.txt`.
  - Copia no backup: `C:\Users\Michael Scott\Documents\Ferriso_migracao_backups\20260611-221918\ferrisoisolamentos.com.br-dns-export.txt`.
  - SHA256: `1C86E4C595E1C4BB0195A437086731400E491BB3CFFBA55406227E6464BE2C6C`.
  - Validacao: contem registros de e-mail, incluindo sinais de MX e SPF.

Avisos:

- O ZIP contem arquivos sensiveis como `config/db.php`; manter esse backup fora de pastas publicas e fora do Git.
- O cron job existente no hPanel contem um segredo em URL. Ele foi identificado, mas o comando completo nao foi transcrito neste documento. Se precisar migrar esse cron, salvar o comando completo em local seguro ou rotacionar o segredo antes da migracao.
- Contas/caixas de e-mail ainda nao foram exportadas/listadas.

## Etapa 3 - Preparacao HostGator

Configuracao realizada/confirmada no Portal HostGator e cPanel:

- Produto/plano: `Plano M`.
- Dominio principal na HostGator: `ferrisoisolamentos.com.br`.
- Usuario cPanel: `fel87493`.
- Servidor: `br1172`.
- Diretorio inicial no cPanel: `/home1/fel87493`.
- Pasta publica confirmada: `/home1/fel87493/public_html`.
- Link temporario informado pelo Portal: `http://br1172.teste.website/~fel87493`.
- IP compartilhado exibido no cPanel: `162.241.203.216`.
- Hostname/IP FTP exibido no Portal: `162.241.203.212 / ferrisoisolamentos.com.br`.
- Nameservers da HostGator exibidos no Portal, apenas para registro futuro: `ns1172.hostgator.com.br` e `ns1173.hostgator.com.br`.
- Banco MySQL novo criado: `fel87493_bd_ferriso`.
- Usuario MySQL novo criado: `fel87493_ferriso`.
- Senha do usuario MySQL: definida pelo usuario no cPanel e nao registrada neste documento.
- Permissoes: `fel87493_ferriso` adicionado ao banco `fel87493_bd_ferriso` com todos os privilegios.
- PHP: dominio ajustado para `PHP 8.2 (ea-php82)` no Gerenciador de MultiPHP.
- MultiPHP INI Editor: dominio usa caminho `/home1/fel87493/public_html/php.ini`, versao `ea-php82`; valores visiveis incluem `display_errors=Off`, `memory_limit=512M`, `post_max_size=516M`, `upload_max_filesize=512M`.
- SSL/AutoSSL: ainda nao valido na HostGator porque o dominio segue apontando para a Hostinger. AutoSSL falhou em 2026-06-12 por DCV/DNS apontando para IPs fora deste servidor, como esperado antes da troca de DNS.

Pendencias desta etapa:

- Validar extensoes/funcoes PHP em ambiente HostGator apos upload com um teste controlado, especialmente `mysqli`, `mbstring`, `curl`, `openssl`, `json`, `session`, `mail` e `allow_url_fopen`.
- Antes de teste por arquivo `hosts`, confirmar qual IP deve ser usado para HTTP: o cPanel exibe `162.241.203.216` como shared IP, enquanto o Portal exibiu `162.241.203.212` como hostname/IP FTP.
- SSL deve ser reexecutado/validado somente depois que o dominio ou teste DNS local apontar corretamente para a HostGator.

## Etapa 4 - Upload de arquivos HostGator

Execucao no cPanel/File Manager:

- Pasta de destino: `/home1/fel87493/public_html`.
- Pacote usado para upload: `C:\Users\Michael Scott\Documents\Ferriso_migracao_backups\20260612-123352\ferriso-public_html-upload.zip`.
  - Tamanho: 42.418.942 bytes, exibido no cPanel como 40,45 MB.
  - SHA256 local: `C0C605D235E2809349CE4F3173FEB6AF28FB10335ACFF452DFCC99E644F9F6EA`.
  - Entradas locais no ZIP: 2586.
- Extracao concluida pelo File Manager em `/public_html`.
- ZIP temporario removido permanentemente do servidor apos a extracao.
- `default.html` padrao da HostGator removido permanentemente para deixar a raiz limpa.
- Nenhum arquivo `.zip` ou `.sql` ficou na raiz do `public_html`.
- Estrutura final confirmada na raiz do `public_html`: `.well-known`, `admin`, `config`, `contato`, `css`, `img`, `js`, `lib`, `newsletter`, `partials`, `scss`, `.htaccess`, `404.php`, `areas.php`, `avaliacoes.php`, `contato.php`, `index.php`, `portfolio.php`, `privacidade.php`, `produtos.php`, `robots.txt`, `sitemap.xml`, `sobre.php`.
- Permissoes observadas: pastas principais `0755`; arquivos principais `0644`.
- Pasta `config` conferida: `config.php` e `db.php` presentes com permissao `0644`.

Pendencias relacionadas:

- Validar se o `.htaccess` precisa de ajuste antes dos testes, pois ele força HTTPS para o dominio real; o SSL da HostGator ainda depende de DNS/AutoSSL.

## Etapa 5 - Restauracao do banco HostGator

Execucao no phpMyAdmin/cPanel:

- Dump importado no banco novo `fel87493_bd_ferriso`.
- Arquivo importado: `u374171611_bd_ferriso.sql`.
- Resultado informado pelo phpMyAdmin: importacao concluida com sucesso, 40 queries executadas.
- Tabelas confirmadas no banco novo: `areas_atuacao`, `avaliacoes`, `contatos`, `newsletter_subscribers`, `produtos`, `projetos`, `usuarios`.
- Contagens vistas no phpMyAdmin: `areas_atuacao` 6, `avaliacoes` 3, `contatos` 6, `newsletter_subscribers` 1, `produtos` 15, `projetos` 5, `usuarios` 2.
- Engine/collation observadas nas tabelas: InnoDB, `utf8mb4_unicode_ci`.
- `config/db.php` no servidor ajustado para `localhost`, banco `fel87493_bd_ferriso`, usuario `fel87493_ferriso`, porta `3306` e charset `utf8mb4`.
- Senha real do banco foi digitada pelo usuario no cPanel e nao foi registrada neste documento nem no Git.
- Validacao segura do editor: sem marcador de senha, sem nome antigo `u374171611`, e com senha nao vazia.

Validacao relacionada:

- Conexao PHP -> MySQL em runtime validada no ambiente HostGator durante os testes pre-DNS por paginas publicas com conteudo do banco e endpoint de login admin com credenciais invalidas.

## Etapa 6 - Testes pre-DNS HostGator

Execucao em 2026-06-14, sem alterar DNS publico:

- Metodo: `curl --resolve ferrisoisolamentos.com.br:80:162.241.203.216`.
- IP validado para HTTP do vhost: `162.241.203.216`.
- O `.htaccess` da HostGator foi ajustado temporariamente para desativar o redirect HTTP -> HTTPS, pois o SSL ainda nao valida antes do DNS.
- Backup remoto do `.htaccess` original salvo fora do `public_html`: `/home1/fel87493/.htaccess.public_html.codex-backup-20260614-1245`.
- Acesso a `/config/db.php` e `/config/config.php` corrigido para HTTP 403.
- `display_errors` que era ligado manualmente em arquivos PHP foi desligado e substituido por `log_errors=1`.

Resultados:

- Paginas publicas HTTP 200: `/`, `/sobre.php`, `/areas.php`, `/produtos.php`, `/portfolio.php`, `/avaliacoes.php`, `/contato.php`, `/privacidade.php`, `/admin/login.php`, `/robots.txt`, `/sitemap.xml`.
- 404 customizado: URL inexistente retorna HTTP 404.
- Protecao: `/.htaccess`, `/config/db.php` e `/config/config.php` retornam HTTP 403.
- Admin protegido: `/admin/home.php` retorna HTTP 302 para login quando sem sessao.
- Conteudo via banco:
  - `/areas.php`: 6 cards renderizados.
  - `/produtos.php`: 13 produtos ativos renderizados.
  - `/portfolio.php`: 5 projetos renderizados.
  - `/avaliacoes.php`: 3 avaliacoes renderizadas.
- Assets principais HTTP 200: CSS Bootstrap, CSS do site, JS principal, logo, carousel, header de produtos, Owl Carousel, Lightbox e WOW.js.
- Formulario de contato: token reCAPTCHA propositalmente invalido retornou `Falha na validacao do reCAPTCHA`, confirmando que a validacao remota foi alcancada sem gravar lead real.
- Newsletter: e-mail invalido retornou HTTP 422, sem erro PHP.
- Admin login: tentativa com usuario/senha invalidos retornou JSON `ok=false`, sem erro PHP.
- HTTPS ainda retorna `302` para `/404.html` no IP da HostGator; isso permanece esperado ate DNS/AutoSSL.

Pendencias desta etapa:

- Reativar redirect HTTP -> HTTPS somente depois que DNS apontar para HostGator e AutoSSL estiver OK.
- Testar login admin com credenciais reais e pelo menos uma tela/acao de CRUD, sem expor senha.
- Testar envio real do formulario de contato somente quando for apropriado gerar um lead/e-mail de teste.
- Testar envio real da newsletter somente se for aceitavel criar inscricao/e-mail de teste.
- Validar console do navegador apos apontamento local/DNS, pois o navegador interno nao usa `curl --resolve`.

## Banco de dados

Tabelas referenciadas pelo codigo:

- `areas_atuacao`
- `avaliacoes`
- `contatos`
- `newsletter_subscribers`
- `produtos`
- `projetos`
- `usuarios`

Ainda falta confirmar na Hostinger:

- Nome real do banco atual.
- Tamanho do banco.
- Quantidade de tabelas.
- Charset/collation.
- Se ha triggers, views, procedures ou eventos.
- Dump SQL completo e integro.

## Configuracoes sensiveis identificadas

Valores sensiveis nao devem ser exibidos, enviados em prints, versionados ou deixados em `public_html`.

- `config/db.php`: contem host, nome do banco, usuario e senha do banco atual.
- `contato/contato_enviar.php`: contem configuracao de reCAPTCHA/validacao de formulario; revisar segredo/chave sem expor valor.
- `admin/config/php_init.php`: configura sessao e CSRF.
- Banco `usuarios`: contem hashes de senha do admin, deve ir no dump SQL e nao ser manipulado manualmente.

Risco Git:

- `config/db.php` esta rastreado pelo Git neste repo. Nao alterei nem expus os valores, mas a remediacao recomendada e criar um `config/db.example.php`, mover credenciais reais para um arquivo/local seguro ou variaveis de ambiente, e remover o arquivo real do rastreamento em uma mudanca planejada.
- `.gitignore` foi adicionado para bloquear novos dumps, backups, arquivos `.env` e arquivos temporarios de migracao.

Arquivos nao encontrados no repo local:

- `wp-config.php`
- `.env`
- `composer.json`
- `artisan`
- arquivos `.sql`
- arquivos `.zip`, `.gz` ou `.tar.gz`

## DNS atual observado publicamente

- A: `212.85.9.27`
- AAAA: `2a02:4780:13:820:0:164d:67db:3`
- NS: `ns1.dns-parking.com`, `ns2.dns-parking.com`
- MX: `mx.uhserver.com`
- TXT/SPF: `v=spf1 include:spf.whservidor.com ?all`
- TXT adicional: Google site verification.

Regra: registrar uma copia completa dos DNS atuais antes de qualquer alteracao.

## E-mail

Ha indicio de e-mail vinculado ao dominio porque existe registro MX atual.

Antes de trocar DNS:

- Listar contas de e-mail existentes.
- Confirmar se caixas antigas precisam ser migradas por IMAP/exportacao.
- Criar as contas equivalentes na HostGator se a HostGator for assumir e-mail.
- Confirmar MX, SPF, DKIM e DMARC.
- Nao alterar MX ate as contas novas estarem prontas.

## Acessos necessarios para prosseguir

Pausar execucao real ate obter:

- Acesso Hostinger/hPanel/cPanel.
- Acesso a arquivos por File Manager, FTP/SFTP ou SSH.
- Acesso ao banco atual por phpMyAdmin ou credenciais MySQL.
- Acesso HostGator/cPanel.
- Acesso de DNS/nameservers, seja Hostinger, Registro.br, Cloudflare ou outro provedor.
- Acesso administrativo aos e-mails do dominio, se existirem.

Nunca enviar senhas aqui em texto aberto. Preferir compartilhamento seguro fora de logs/commits.

## Checklist de migracao

### 1. Levantamento na Hostinger

- [x] Confirmar pasta publica real do dominio: `public_html`.
- [x] Confirmar versao PHP atual: PHP 8.2.
- [x] Confirmar extensoes PHP habilitadas: principais dependencias confirmadas ativas.
- [x] Confirmar `allow_url_fopen` ou alternativa para validacao reCAPTCHA: `allowUrlFopen` ativo.
- [x] Confirmar estrutura completa de diretorios: File Browser especifico mostra `public_html/` e `DO_NOT_UPLOAD_HERE`; `public_html/` vazio.
- [x] Confirmar banco vinculado ao site: MySQL associado ao dominio no hPanel.
- [x] Confirmar subdominios: nenhum existente visivel no hPanel.
- [x] Confirmar redirects: nenhum existente visivel no hPanel.
- [x] Confirmar cron jobs: 1 cron existente; comando contem segredo em URL e deve ser tratado como sensivel.
- [x] Confirmar SSL atual: Lifetime SSL ativo.
- [x] Confirmar regras adicionais alem do `.htaccess`: paginas de erro padrao e telas extras verificadas; sem listas claras de bloqueios/redirecionamentos adicionais.
- [ ] Confirmar contas de e-mail: DNS de e-mail existe, mas caixas nao foram confirmadas no hPanel.

### 2. Backup completo

- [x] Compactar todos os arquivos do site a partir do repositorio local validado.
- [x] Exportar dump SQL completo: validado estruturalmente com 7 tabelas esperadas.
- [ ] Exportar/listar contas de e-mail.
- [x] Salvar configuracoes DNS atuais: export TXT copiado para backup local.
- [x] Salvar configuracoes PHP atuais: registradas neste runbook.
- [ ] Salvar cron job completo em local seguro, se ele precisar ser migrado; comando contem segredo e nao foi transcrito aqui.
- [x] Salvar redirects: nenhum redirect existente visivel no hPanel.
- [x] Baixar backup localmente.
- [x] Validar que o compactado abre.
- [x] Validar que o dump SQL nao esta vazio.
- [x] Validar que o dump contem as tabelas esperadas.

### 3. Preparacao na HostGator

- [x] Adicionar `ferrisoisolamentos.com.br` no cPanel/Plano M.
- [x] Confirmar pasta publica correta: `/home1/fel87493/public_html`.
- [x] Criar banco novo: `fel87493_bd_ferriso`.
- [x] Criar usuario novo com senha forte: `fel87493_ferriso`; senha definida pelo usuario e nao registrada.
- [x] Dar permissao do usuario somente ao banco novo: todos os privilegios no banco `fel87493_bd_ferriso`.
- [x] Ajustar versao PHP compativel: `PHP 8.2 (ea-php82)`.
- [x] Validar extensoes/funcoes necessarias apos upload com teste controlado: principais fluxos PHP/MySQL/session/mbstring/reCAPTCHA validados; envio real de `mail()` ainda nao testado.
- [x] Preparar SSL, sabendo que validacao pode depender do DNS: AutoSSL identificado, pendente ate DNS apontar para HostGator.

### 4. Upload de arquivos

- [x] Enviar arquivos do repositorio local para a pasta correta na HostGator: `/home1/fel87493/public_html`.
- [x] Preservar estrutura original do repositorio como conteudo da pasta publica.
- [x] Conferir permissoes: pastas principais `0755`, arquivos principais `0644`.
- [x] Proteger arquivos sensiveis: nenhum `.zip` ou `.sql` ficou publico; `config/db.php` ajustado sem registrar senha; `/config` bloqueado por HTTP 403.
- [x] Remover qualquer backup publico depois da restauracao: ZIP temporario removido.

### 5. Restauracao do banco

- [x] Importar dump SQL no banco novo: `fel87493_bd_ferriso`.
- [x] Conferir total de tabelas: 7 tabelas esperadas confirmadas.
- [x] Conferir charset/collation: tabelas em `utf8mb4_unicode_ci`.
- [x] Conferir erros de importacao: phpMyAdmin informou sucesso, 40 queries executadas.
- [x] Ajustar `config/db.php` para banco novo sem versionar credenciais reais.

### 6. Teste antes do DNS

Metodo recomendado: arquivo `hosts` local apontando `ferrisoisolamentos.com.br` para o IP da HostGator, ou preview temporario da HostGator.

Observacoes iniciais sem alterar DNS:

- Teste com `curl --resolve` em 2026-06-14 confirmou que `162.241.203.216` responde via HTTP para `ferrisoisolamentos.com.br` com `301` para HTTPS, refletindo a regra atual do `.htaccess`.
- Teste HTTPS com `162.241.203.216` retornou `302` para `/404.html`; isso e compativel com SSL/AutoSSL ainda nao validado na HostGator.
- Testes em `162.241.203.212` retornaram `/404.html`, entao o IP mais provavel para HTTP do site e `162.241.203.216`.
- Tentativa de validar PHP/MySQL pelo Terminal do cPanel ficou pendente porque o Terminal ficou sem entrada habilitada para automacao.
- Para testar as paginas antes do DNS, foi usado `curl --resolve` e a regra de HTTPS do `.htaccess` foi desativada temporariamente na HostGator. Reativar somente apos DNS/AutoSSL OK.

- [x] Home.
- [x] Sobre.
- [x] Portfolio.
- [x] Areas.
- [x] Produtos.
- [x] Avaliacoes.
- [x] Contato.
- [x] Admin login.
- [ ] CRUD/admin principal.
- [x] Formulario de contato: validacao de erro/reCAPTCHA testada sem envio real.
- [x] Newsletter: validacao de erro testada sem inscricao real.
- [x] Imagens.
- [x] CSS/JS.
- [x] Links internos principais/paginas publicas.
- [x] 404.
- [ ] Redirect HTTP -> HTTPS.
- [x] Logs PHP sem erro 500 nas rotas testadas: nenhum `Fatal error`, `Warning`, `Parse error` ou erro MySQL exposto.
- [ ] Console do navegador sem erro critico.

### 7. Troca de DNS

Executar somente depois dos testes aprovados.

- [x] Registrar DNS antigos.
- [x] Escolher estrategia: A/CNAME/MX pontuais, mantendo nameservers da Hostinger.
- [x] Preservar MX se e-mail continuar fora da HostGator: `mx.uhserver.com` mantido.
- [x] Alterar DNS: `A @` alterado de `212.85.9.27` para `162.241.203.216`; `AAAA @` antigo da Hostinger removido.
- [x] Monitorar propagacao inicial: A resolvendo para HostGator em Google, Cloudflare e resolvedor local; AAAA removido nos nameservers autoritativos e com cache externo temporario esperado.

### 8. Pos-migracao

- [ ] Testar dominio real apos propagacao.
- [ ] Validar SSL.
- [ ] Forcar HTTPS somente apos SSL OK.
- [ ] Testar formulario.
- [ ] Testar newsletter.
- [ ] Testar e-mails.
- [ ] Verificar logs.
- [ ] Verificar `robots.txt` e `sitemap.xml`.
- [ ] Limpar caches.
- [ ] Remover arquivos temporarios/backups publicos.
- [ ] Manter backup final fora do servidor.

### 9. Rollback

- [ ] Manter Hostinger ativa.
- [ ] Manter DNS antigo documentado.
- [ ] Se falhar, reverter DNS para Hostinger.
- [ ] Documentar causa antes de nova tentativa.

## Entregaveis finais

- [ ] Checklist do que foi migrado.
- [ ] Confirmacao final do tipo de site.
- [ ] Lista de arquivos/configuracoes sensiveis, sem senhas.
- [ ] Nome do banco novo na HostGator.
- [ ] Resultado da importacao do banco.
- [ ] Resultado dos testes antes do DNS.
- [ ] Resultado dos testes apos DNS.
- [ ] Confirmacao sobre migracao de e-mails.
- [ ] Pendencias.
- [ ] Recomendacao final sobre cancelamento da Hostinger.

Recomendacao final padrao: cancelar Hostinger somente depois de alguns dias de monitoramento sem erros, com backup final salvo fora dos servidores e e-mails confirmados.
