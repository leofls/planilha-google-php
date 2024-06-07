<?php
include 'conectando.php';

// Obter o token de acesso
$accessToken = getAccessToken($jsonKeyFilePath);

// Fazer a solicitação à API do Google Sheets
$response = file_get_contents(
    "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId/values/$range",
    false,
    stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $accessToken
        ]
    ])
);

$data = json_decode($response, true);

if (empty($data['values'])) {
    echo "Nenhum dado encontrado.";
} else {
    header('Content-Type: application/json');
    echo json_encode($data['values'], JSON_PRETTY_PRINT);
    // print_r($data['values']);
}