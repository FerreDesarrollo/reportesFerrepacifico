<?php
/*$host = 'ferrepacifico.com.mx';
$db   = 'ferrepac_reportes';
$user = 'ferrepac_reporte';
$pass = '0t+4KVH]1Fhi';
$port = '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

session_start();*/

require_once __DIR__.'/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $_ENV['MYSQL_HOST'], $_ENV['MYSQL_PORT'] ?? 3306, $_ENV['MYSQL_DB']
);

try {
    $pdo = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Error de conexión.');
}

session_start();
?>
