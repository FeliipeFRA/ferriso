<?php
// ferriso_api.php
// Helpers de CRUD para projetos, produtos, avaliações e contatos

require_once __DIR__ . '/../config/db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Gera um slug simples a partir de um texto.
 * Ex.: "Telha Galvalume 0,5mm" => "telha-galvalume-0-5mm"
 */
function ferriso_slugify(string $txt): string
{
    $txt = trim(mb_strtolower($txt, 'UTF-8'));
    // troca acentos
    $txt = iconv('UTF-8', 'ASCII//TRANSLIT', $txt);
    // tudo que não for letra/número vira hífen
    $txt = preg_replace('/[^a-z0-9]+/', '-', $txt);
    $txt = trim($txt, '-');
    return $txt ?: 'item';
}

/**
 * Garante slug único nas tabelas que têm coluna slug.
 * $tabela deve ser "produtos" ou "projetos".
 */
function ferriso_unique_slug(mysqli $con, string $tabela, string $slug, ?int $ignoreId = null): string
{
    $permitidas = ['produtos', 'projetos'];
    if (!in_array($tabela, $permitidas, true)) {
        throw new InvalidArgumentException('Tabela não permite slug.');
    }

    $base = $slug ?: 'item';
    $atual = $base;
    $i     = 1;

    while (true) {
        if ($ignoreId) {
            $sql  = "SELECT id FROM {$tabela} WHERE slug = ? AND id <> ? LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('si', $atual, $ignoreId);
        } else {
            $sql  = "SELECT id FROM {$tabela} WHERE slug = ? LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('s', $atual);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        if (!$row) {
            return $atual;
        }

        $i++;
        $atual = $base . '-' . $i;
    }
}

/* =========================================================
 * LISTAGENS
 * =======================================================*/

/** Lista todos os produtos (ou só ativos). */
/** Lista todos os produtos (ou só ativos), com ordenação configurável. */
function ferriso_list_produtos(
    mysqli $con,
    bool $somenteAtivos = false,
    string $orderBy = 'nome',
    string $dir = 'ASC'
): array {
    // Campos permitidos para ordenação
    $validOrder = [
        'nome',
        'categoria',
        'criado_em',
        'atualizado_em',
        'ativo',
        'destaque'
    ];

    if (!in_array($orderBy, $validOrder, true)) {
        $orderBy = 'nome';
    }

    $dir = strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC';

    $sql = "SELECT id, nome, categoria, slug, resumo, capa_img, destaque, ativo, criado_em, atualizado_em
            FROM produtos";

    if ($somenteAtivos) {
        $sql .= " WHERE ativo = 1";
    }

    // Ordena pelo campo escolhido + nome como tie-break
    $sql .= " ORDER BY {$orderBy} {$dir}, nome ASC";

    $res = $con->query($sql);
    return $res->fetch_all(MYSQLI_ASSOC);
}


/**
 * Busca um produto pelo ID.
 */
function ferriso_get_produto(mysqli $con, int $id): ?array
{
    $sql = "SELECT id, nome, categoria, slug, resumo, descricao, capa_img,
                   destaque, ativo, criado_em, atualizado_em
            FROM produtos
            WHERE id = ?
            LIMIT 1";

    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    return $row ?: null;
}


/** Lista todos os projetos (ou só ativos). */
function ferriso_list_projetos(mysqli $con, bool $somenteAtivos = false): array
{
    $sql = "SELECT id, titulo, slug, cliente, localizacao, data_projeto, resumo, capa_img, destaque, ativo, criado_em, atualizado_em
            FROM projetos";
    if ($somenteAtivos) {
        $sql .= " WHERE ativo = 1";
    }
    $sql .= " ORDER BY data_projeto DESC, titulo ASC";

    $res = $con->query($sql);
    return $res->fetch_all(MYSQLI_ASSOC);
}

/** Lista todas as avaliações (ou só ativas). */
function ferriso_list_avaliacoes(mysqli $con, bool $somenteAtivas = false): array
{
    $sql = "SELECT id, projeto_id, nome_cliente, empresa, titulo, comentario, ativo, destaque, criado_em
            FROM avaliacoes";
    if ($somenteAtivas) {
        $sql .= " WHERE ativo = 1";
    }
    $sql .= " ORDER BY criado_em DESC";

    $res = $con->query($sql);
    return $res->fetch_all(MYSQLI_ASSOC);
}

/**
 * Lista contatos.
 * $filtro:
 *   null          -> todos
 *   'para_ler'    -> lido = 0
 *   'para_resp'   -> respondido = 0
 */
function ferriso_list_contatos(mysqli $con, ?string $filtro = null): array
{
    $sql   = "SELECT id, nome, email, telefone, assunto, mensagem, origem, ip,
                     lido, respondido, criado_em
              FROM contatos";
    $where = [];

    if ($filtro === 'para_ler') {
        $where[] = "lido = 0";
    } elseif ($filtro === 'para_resp') {
        $where[] = "respondido = 0";
    }

    if ($where) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $sql .= " ORDER BY criado_em DESC";

    $res = $con->query($sql);
    return $res->fetch_all(MYSQLI_ASSOC);
}

/* =========================================================
 * FLAGS (ativo / destaque / lido / respondido)
 * =======================================================*/

/**
 * Troca uma flag booleana em uma tabela específica.
 * $tipo: 'produtos','projetos','avaliacoes','contatos'
 * $flag: 'ativo','destaque','lido','respondido'
 */
function ferriso_set_flag(mysqli $con, string $tipo, string $flag, int $id, bool $valor): bool
{
    $permitidos = [
        'produtos'   => ['ativo', 'destaque'],
        'projetos'   => ['ativo', 'destaque'],
        'avaliacoes' => ['ativo', 'destaque'],
        'contatos'   => ['lido', 'respondido'],
    ];

    if (!isset($permitidos[$tipo]) || !in_array($flag, $permitidos[$tipo], true)) {
        throw new InvalidArgumentException('Tipo ou flag inválidos.');
    }

    $id    = (int)$id;
    $valor = $valor ? 1 : 0;

    $sql  = "UPDATE {$tipo} SET {$flag} = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ii', $valor, $id);
    $stmt->execute();

    return ($stmt->affected_rows >= 0);
}

/** Atalho: seta ativo/destaque para produtos, projetos e avaliações. */
function ferriso_set_ativo(mysqli $con, string $tipo, int $id, bool $ativo): bool
{
    return ferriso_set_flag($con, $tipo, 'ativo', $id, $ativo);
}

function ferriso_set_destaque(mysqli $con, string $tipo, int $id, bool $destaque): bool
{
    return ferriso_set_flag($con, $tipo, 'destaque', $id, $destaque);
}

/** Atalhos para contatos. */
function ferriso_set_contato_lido(mysqli $con, int $id, bool $lido): bool
{
    return ferriso_set_flag($con, 'contatos', 'lido', $id, $lido);
}

function ferriso_set_contato_respondido(mysqli $con, int $id, bool $resp): bool
{
    return ferriso_set_flag($con, 'contatos', 'respondido', $id, $resp);
}

/* =========================================================
 * EXCLUIR REGISTROS
 * =======================================================*/

/**
 * Exclui um registro da tabela indicada.
 * $tipo: 'produtos','projetos','avaliacoes','contatos'
 */
function ferriso_delete_registro(mysqli $con, string $tipo, int $id): bool
{
    $permitidos = ['produtos', 'projetos', 'avaliacoes', 'contatos'];
    if (!in_array($tipo, $permitidos, true)) {
        throw new InvalidArgumentException('Tipo inválido para exclusão.');
    }

    $id   = (int)$id;
    $sql  = "DELETE FROM {$tipo} WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    return ($stmt->affected_rows > 0);
}

/* =========================================================
 * CRIAR NOVOS (INSERT)
 * =======================================================*/

/**
 * Cria um novo produto.
 * Espera em $data (chaves):
 *  - nome (obrigatório)
 *  - categoria (revestimento_metalico, isolantes_termicos, acessorios, outros)
 *  - slug (opcional, gerado do nome se vazio)
 *  - resumo, descricao, capa_img (opcionais)
 *  - destaque, ativo (0/1, opcionais)
 *
 * Retorna o ID inserido.
 */
function ferriso_criar_produto(mysqli $con, array $data): int
{
    $nome      = trim($data['nome'] ?? '');
    $categoria = $data['categoria'] ?? 'outros';

    if ($nome === '') {
        throw new InvalidArgumentException('Nome do produto é obrigatório.');
    }

    $slug      = trim($data['slug'] ?? '');
    $slug      = ferriso_slugify($slug ?: $nome);
    $slug      = ferriso_unique_slug($con, 'produtos', $slug);

    $resumo    = trim($data['resumo'] ?? '');
    $descricao = trim($data['descricao'] ?? '');
    $capa_img  = trim($data['capa_img'] ?? '');
    $destaque  = !empty($data['destaque']) ? 1 : 0;
    $ativo     = array_key_exists('ativo', $data)
        ? (int)(bool)$data['ativo']
        : 1;

    $sql = "INSERT INTO produtos
              (nome, categoria, slug, resumo, descricao, capa_img, destaque, ativo)
            VALUES
              (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        'ssssssii',
        $nome,
        $categoria,
        $slug,
        $resumo,
        $descricao,
        $capa_img,
        $destaque,
        $ativo
    );
    $stmt->execute();

    return (int)$con->insert_id;
}

/**
 * Atualiza um produto existente.
 * Usa o mesmo padrão de slug da criação (único por tabela).
 */
function ferriso_atualizar_produto(mysqli $con, int $id, array $data): bool
{
    $prod = ferriso_get_produto($con, $id);
    if (!$prod) {
        throw new RuntimeException('Produto não encontrado.');
    }

    // Nome
    $nome = trim($data['nome'] ?? $prod['nome']);
    if ($nome === '') {
        throw new InvalidArgumentException('Nome do produto é obrigatório.');
    }

    // Categoria
    $categoria = $data['categoria'] ?? $prod['categoria'];

    // Slug: se vier em branco, gera a partir do nome
    $slugBruto = trim($data['slug'] ?? '');
    if ($slugBruto === '') {
        $slugBruto = $nome;
    }
    $slug = ferriso_slugify($slugBruto);
    $slug = ferriso_unique_slug($con, 'produtos', $slug, $id);

    // Demais campos
    $resumo    = trim($data['resumo']    ?? ($prod['resumo']    ?? ''));
    $descricao = trim($data['descricao'] ?? ($prod['descricao'] ?? ''));
    $capa_img  = trim($data['capa_img']  ?? ($prod['capa_img']  ?? ''));

    // Flags
    $destaque = !empty($data['destaque']) ? 1 : 0;
    $ativo    = array_key_exists('ativo', $data)
        ? (int)(bool)$data['ativo']
        : (int)$prod['ativo'];

    $sql = "UPDATE produtos
               SET nome      = ?,
                   categoria = ?,
                   slug      = ?,
                   resumo    = ?,
                   descricao = ?,
                   capa_img  = ?,
                   destaque  = ?,
                   ativo     = ?
             WHERE id        = ?
             LIMIT 1";

    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        'ssssssiii',
        $nome,
        $categoria,
        $slug,
        $resumo,
        $descricao,
        $capa_img,
        $destaque,
        $ativo,
        $id
    );
    $stmt->execute();

    return ($stmt->affected_rows >= 0);
}


/**
 * Cria um novo projeto.
 * Espera em $data:
 *  - titulo (obrigatório)
 *  - cliente, localizacao, data_projeto (YYYY-MM-DD), resumo, descricao, capa_img (opcionais)
 *  - slug (opcional, gerado do título se vazio)
 *  - destaque, ativo (0/1, opcionais)
 */
function ferriso_criar_projeto(mysqli $con, array $data): int
{
    $titulo = trim($data['titulo'] ?? '');
    if ($titulo === '') {
        throw new InvalidArgumentException('Título do projeto é obrigatório.');
    }

    $slug   = trim($data['slug'] ?? '');
    $slug   = ferriso_slugify($slug ?: $titulo);
    $slug   = ferriso_unique_slug($con, 'projetos', $slug);

    $cliente      = trim($data['cliente'] ?? '');
    $localizacao  = trim($data['localizacao'] ?? '');
    $dataProjeto  = trim($data['data_projeto'] ?? '');
    $resumo       = trim($data['resumo'] ?? '');
    $descricao    = trim($data['descricao'] ?? '');
    $capa_img     = trim($data['capa_img'] ?? '');
    $ativo        = array_key_exists('ativo', $data)
        ? (int)(bool)$data['ativo']
        : 1;
    $destaque     = !empty($data['destaque']) ? 1 : 0;

    $sql = "INSERT INTO projetos
              (titulo, slug, cliente, localizacao, data_projeto, resumo, descricao, capa_img, ativo, destaque)
            VALUES
              (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        'ssssssssii',
        $titulo,
        $slug,
        $cliente,
        $localizacao,
        $dataProjeto,
        $resumo,
        $descricao,
        $capa_img,
        $ativo,
        $destaque
    );
    $stmt->execute();

    return (int)$con->insert_id;
}

/**
 * Cria uma nova avaliação.
 * Espera em $data:
 *  - nome_cliente (obrigatório)
 *  - comentario   (obrigatório)
 *  - projeto_id (opcional, int)
 *  - empresa, titulo (opcionais)
 *  - ativo, destaque (0/1, opcionais)
 */
function ferriso_criar_avaliacao(mysqli $con, array $data): int
{
    $nome_cliente = trim($data['nome_cliente'] ?? '');
    $comentario   = trim($data['comentario'] ?? '');

    if ($nome_cliente === '' || $comentario === '') {
        throw new InvalidArgumentException('Nome do cliente e comentário são obrigatórios.');
    }

    $projeto_id = isset($data['projeto_id']) && $data['projeto_id'] !== ''
        ? (int)$data['projeto_id']
        : null;

    $empresa  = trim($data['empresa'] ?? '');
    $titulo   = trim($data['titulo'] ?? '');
    $ativo    = array_key_exists('ativo', $data)
        ? (int)(bool)$data['ativo']
        : 1;
    $destaque = !empty($data['destaque']) ? 1 : 0;

    $sql = "INSERT INTO avaliacoes
              (projeto_id, nome_cliente, empresa, titulo, comentario, ativo, destaque)
            VALUES
              (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);

    if ($projeto_id === null) {
        // bind_param não aceita diretamente null em 'i', então usamos tipo 's' e passamos null,
        // deixando o MySQL converter para NULL no insert.
        $projeto_id_param = null;
        $stmt->bind_param(
            'ssssssi',
            $projeto_id_param,
            $nome_cliente,
            $empresa,
            $titulo,
            $comentario,
            $ativo,
            $destaque
        );
    } else {
        $stmt->bind_param(
            'issssii',
            $projeto_id,
            $nome_cliente,
            $empresa,
            $titulo,
            $comentario,
            $ativo,
            $destaque
        );
    }

    $stmt->execute();
    return (int)$con->insert_id;
}
