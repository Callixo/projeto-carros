<?php
// Versão "tudo em um arquivo" — credenciais embutidas para deploy rápido.
// ATENÇÃO: não comite este arquivo em repositórios públicos!

/********** CONFIGURAÇÃO (edite aqui) **********/
$db_host = 'bancowebtune.cl4ge2ygios4.us-east-1.rds.amazonaws.com'; // endpoint RDS
$db_port = '3306';
$db_name = 'webtunedb';
$db_user = 'admin';
$db_pass = 'Webtune2025';
$show_errors = false; // true para exibir mensagens detalhadas (só em dev)
/***********************************************/

ini_set('display_errors', $show_errors ? '1' : '0');
error_reporting($show_errors ? E_ALL : 0);

// DSN (MySQL)
$dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4";

// Opções PDO recomendadas
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    // PDO::ATTR_PERSISTENT => true, // opcional: habilite se preferir conexões persistentes
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
    // conexão bem-sucedida (comentado para não vazar em produção)
    // if ($show_errors) echo "Conectado com sucesso ao banco.\n";
} catch (PDOException $e) {
    // log local do erro
    error_log('DB Connection Error: ' . $e->getMessage());

    if ($show_errors) {
        // ambiente de desenvolvimento — exibe erro detalhado
        echo "Erro ao conectar ao banco: " . htmlspecialchars($e->getMessage());
    } else {
        // ambiente de produção — mensagem genérica
        http_response_code(500);
        echo "Falha na conexão com o banco de dados.";
    }
    exit;
}

/*
Uso:
require_once 'db_connect.php';
$stmt = $pdo->query("SELECT 1");
*/
?>
