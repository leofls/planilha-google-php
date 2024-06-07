<?php
include 'conectando.php';

// Obter o token de acesso
$accessToken = getAccessTokenInsert($jsonKeyFilePath);

// USER_ENTERED significa que a API deve interpretar e formatar 
// os valores como se fossem inseridos manualmente pelo usuário. 
// Outra opção seria RAW, que insere os dados exatamente como são fornecidos.
$inputOption = "RAW"; 

// Dados que você quer inserir
$values = [
    ["nome", "9999", "email@dslkdl.com"], 
];

// Preparar os dados para a API
$data = [
    'range' => $range,
    'majorDimension' => 'ROWS',
    'values' => $values
];

// Fazer a solicitação à API do Google Sheets para inserir dados
$response = file_get_contents(
    "https://sheets.googleapis.com/v4/spreadsheets/$spreadsheetId/values/$range:append?valueInputOption=$inputOption",
    false,
    stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ],
            'content' => json_encode($data)
        ]
    ])
);

$result = json_decode($response, true);

if (isset($result['updates'])) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Falha ao inserir dados.";
}


?>
