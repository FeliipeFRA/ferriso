<?php
define('IMG_FALLBACK', '/img/padrao.jpg');      // imagem padrão
define('UPLOADS_BASE', '/img');            // URL base pública
define('UPLOADS_DIR',  $_SERVER['DOCUMENT_ROOT'] . UPLOADS_BASE); // caminho físico

function img_url(?string $path): string
{
    if (!$path) return IMG_FALLBACK;

    $rel = ltrim($path, '/');
    if (strpos($rel, '..') !== false) return IMG_FALLBACK;

    if (str_starts_with($rel, ltrim(UPLOADS_BASE, '/'))) {
        $fs = $_SERVER['DOCUMENT_ROOT'] . '/' . $rel;
        return is_readable($fs) ? '/' . $rel : IMG_FALLBACK;
    }

    $fs = UPLOADS_DIR . '/' . $rel;          // respeita subpastas "areas/..."
    return is_readable($fs) ? UPLOADS_BASE . '/' . $rel : IMG_FALLBACK;
}
