<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;
use GuzzleHttp\Exception\RequestException;

ini_set('max_execution_time', 0);

// 1. Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 2. Conexión PDO a MySQL
$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $_ENV['MYSQL_HOST'],
    $_ENV['MYSQL_PORT'] ?: 3306,
    $_ENV['MYSQL_DB']
);

try {
    $pdo = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error al conectar a MySQL: " . $e->getMessage());
}

// 3. Consulta MySQL solo de registros que quieres sincronizar
$sql = <<<SQL
SELECT
    id,
    id_netsuite,
    CONCAT_WS(' ', folio, ' - ', idprograma) AS name,
    folio, 
    idprograma AS programa,
    fecha_programa, 
    estatus, 
    fecha_salida, 
    salida,
    fecha_entrada, 
    entrada,
    chofer_clave, 
    chofer_nombre,
    unidad, 
    vehiculo_descripcion AS vehiculo_desc,
    unidades, 
    total, 
    peso, 
    ruta,
    cliente, 
    ciudad_estado, 
    colonia, 
    calle, 
    poblacion,
    codigo_postal AS cp, 
    telefono1 AS telefono,
    contacto, 
    envio,
    fecha_salida_app AS fecha_salida_app,
    fecha_fin_app AS fecha_fin_app,
    fecha_documento AS fecha_doc,
    Hora_documento AS hora_doc,
    id_dircliente AS id_dircliente,
    vendedor AS vendedor,
    observaciones AS observaciones
FROM Envios_logistica2
ORDER BY 
    id DESC
LIMIT 1000;
SQL;

$rows = $pdo->query($sql)->fetchAll();
if (!$rows) {
    echo "No hay registros pendientes de sincronizar.\n";
    exit;
}

// 4. Datos de autenticación NetSuite
$account        = $_ENV['NS_ACCOUNT'];
$consumerKey    = $_ENV['NS_CONSUMER_KEY'];
$consumerSecret = $_ENV['NS_CONSUMER_SECRET'];
$tokenId        = $_ENV['NS_TOKEN_ID'];
$tokenSecret    = $_ENV['NS_TOKEN_SECRET'];
$script         = $_ENV['NS_SCRIPT'];
$deploy         = $_ENV['NS_DEPLOY'];

$baseUrl = "https://{$account}.restlets.api.netsuite.com/app/site/hosting/restlet.nl";
$url     = "{$baseUrl}?script={$script}&deploy={$deploy}";
$client  = new Client(['timeout' => 60]);

// 5. Función para firmar y enviar
function sendToRestlet(array $payload, Client $client, $url,
                       $account, $consumerKey, $consumerSecret,
                       $tokenId, $tokenSecret)
{
    $nonce           = bin2hex(random_bytes(16));
    $timestamp       = (string) time();
    $signatureMethod = 'HMAC-SHA256';
    $version         = '1.0';

    $params = http_build_query([
        'deploy'                 => $_ENV['NS_DEPLOY'],
        'oauth_consumer_key'     => $consumerKey,
        'oauth_nonce'            => $nonce,
        'oauth_signature_method' => $signatureMethod,
        'oauth_timestamp'        => $timestamp,
        'oauth_token'            => $tokenId,
        'oauth_version'          => $version,
        'script'                 => $_ENV['NS_SCRIPT'],
    ], '', '&', PHP_QUERY_RFC3986);

    $baseString = 'POST&' . rawurlencode(strtok($url, '?')) . '&' . rawurlencode($params);
    $signKey    = rawurlencode($consumerSecret) . '&' . rawurlencode($tokenSecret);
    $signature  = base64_encode(hash_hmac('sha256', $baseString, $signKey, true));

    $authHeader = 'OAuth '
        . 'realm="' . rawurlencode($account) . '",'
        . 'oauth_consumer_key="'  . rawurlencode($consumerKey) . '",'
        . 'oauth_token="'         . rawurlencode($tokenId)     . '",'
        . 'oauth_signature_method="HMAC-SHA256",'
        . 'oauth_timestamp="'     . $timestamp  . '",'
        . 'oauth_nonce="'         . $nonce      . '",'
        . 'oauth_version="1.0",'
        . 'oauth_signature="'     . rawurlencode($signature) . '"';

    $response = $client->post($url, [
        'headers' => [
            'Authorization' => $authHeader,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ],
        'json' => $payload
    ]);

    $body = json_decode($response->getBody(), true);
    if (!isset($body['success']) || !$body['success']) {
        throw new \RuntimeException('Respuesta inesperada de NetSuite: ' . $response->getBody());
    }

    return $body['id'];
}

// 6. Recorrer registros y sincronizar
$ok = $fail = 0;

foreach ($rows as $row) {
    $row['id_externo'] = $row['id'];

    // Si ya tiene un id_netsuite, úsalo como id para el Restlet
    if (!empty($row['id_netsuite'])) {
        $row['id'] = (int) $row['id_netsuite'];
    } else {
        unset($row['id']);
    }

    // Convertir NULLs a cadenas vacías para NetSuite
    $payload = array_map(fn($v) => $v === null ? '' : $v, $row);

    try {
        $newId = sendToRestlet(
            $payload, $client, $url,
            $account, $consumerKey, $consumerSecret,
            $tokenId, $tokenSecret
        );

        echo "✅ Registro sincronizado (NetSuite ID {$newId})\n";
        $ok++;

        // Guardar el nuevo ID en la tabla
        $pdo->prepare("UPDATE Envios_logistica2 SET id_netsuite = ?, sincronizado = 1 WHERE id = ?")
            ->execute([$newId, $row['id_externo']]);

    } catch (RequestException $e) {
        echo "❌ Error HTTP: {$e->getMessage()}\n";
        $fail++;
    } catch (\Throwable $e) {
        echo "❌ Error general: {$e->getMessage()}\n";
        $fail++;
    }
}

echo "\n📦 Sincronización finalizada. OK = {$ok}, errores = {$fail}\n";
