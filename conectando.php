<?php
require_once "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$jsonKeyFilePath = $_ENV['FILE_CREDENTIALS'];
$sheet_id = $_ENV['SHEET_ID'];
$range = $_ENV['RANGE'];

// Implementação mínima para criar e assinar um JWT
class JWT {
    public static function encode($payload, $key, $algo = 'RS256') {
        $header = json_encode(['typ' => 'JWT', 'alg' => $algo]);
        $segments = [];
        $segments[] = self::urlsafeB64Encode($header);
        $segments[] = self::urlsafeB64Encode(json_encode($payload));
        $signing_input = implode('.', $segments);
        $signature = self::sign($signing_input, $key, $algo);
        $segments[] = self::urlsafeB64Encode($signature);
        return implode('.', $segments);
    }

    private static function sign($input, $key, $algo) {
        $algorithms = [
            'RS256' => 'sha256'
        ];
        if (!isset($algorithms[$algo])) {
            throw new Exception("Algorithm not supported");
        }
        $algorithm = $algorithms[$algo];
        openssl_sign($input, $signature, $key, $algorithm);
        return $signature;
    }

    private static function urlsafeB64Encode($data) {
        $b64 = base64_encode($data);
        $b64 = str_replace(['+', '/', '='], ['-', '_', ''], $b64);
        return $b64;
    }
}

function getAccessToken($jsonKeyFilePath) {
    $jsonKey = json_decode(file_get_contents($jsonKeyFilePath), true);

    $now = time();
    $exp = $now + 3600; // 1 hora de expiração

    $payload = [
        "iss" => $jsonKey['client_email'],
        "sub" => $jsonKey['client_email'],
        "scope" => "https://www.googleapis.com/auth/spreadsheets.readonly",
        "aud" => "https://oauth2.googleapis.com/token",
        "iat" => $now,
        "exp" => $exp
    ];

    $jwt = JWT::encode($payload, $jsonKey['private_key']);

    $response = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ])
        ]
    ]));

    $response = json_decode($response, true);
    return $response['access_token'];
}

function getAccessTokenInsert($jsonKeyFilePath) {
    $jsonKey = json_decode(file_get_contents($jsonKeyFilePath), true);

    $now = time();
    $exp = $now + 3600; // 1 hora de expiração

    $payload = [
        "iss" => $jsonKey['client_email'],
        "sub" => $jsonKey['client_email'],
        "scope" => "https://www.googleapis.com/auth/spreadsheets",
        "aud" => "https://oauth2.googleapis.com/token",
        "iat" => $now,
        "exp" => $exp
    ];

    $jwt = JWT::encode($payload, $jsonKey['private_key']);

    $response = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ])
        ]
    ]));

    $response = json_decode($response, true);
    return $response['access_token'];
}

// Caminho para o seu arquivo JSON de credenciais
$jsonKeyFilePath = "$jsonKeyFilePath";



// ID da planilha e o intervalo de dados que você quer acessar
$spreadsheetId = $sheet_id;



?>
