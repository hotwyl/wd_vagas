<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Entity\Vaga;

//busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

//filtro status
$filtroStatus = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
$filtroStatus = in_array($filtroStatus,['s','n'])?$filtroStatus:'';

//condições sql
$condicoes = [
    strlen($busca) ? 'titulo LIKE "%'.str_replace(' ', '%', $busca).'%"':null,
    strlen($filtroStatus) ? 'ativo = "'.$filtroStatus.'"':null,
];

//remove array vazio ou null
$condicoes = array_filter($condicoes);

//clausula where
$where = implode(' AND ', $condicoes);

// echo "<pre>"; print_r($where); echo "</pre>"; exit;

//obtem as vagas
$vagas = Vaga::getVagas($where);

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/listagem.php';
include __DIR__ . '/includes/footer.php';
