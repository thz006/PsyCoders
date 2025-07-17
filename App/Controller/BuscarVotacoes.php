<?php
require_once __DIR__ . '/../Model/Votacao.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

$votacao = new VotacaoModel();

$resultado = $votacao->getAllEnquetes();
// print_r($resultado);

if ($resultado) {
    echo json_encode($resultado);
} else {
    echo json_encode(["erro" => "Erro ao buscar enquetes"]);
}

?>