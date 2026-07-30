<?php
/**
 * Rotina Servidora de Busca e Filtros
 * Este arquivo processa os dados específicos solicitados pela index.php
 */
require_once "config.php";

// 1. Capturar os filtros vindos da URL (GET) com sanitização básica
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$preco_min = isset($_GET['min']) && is_numeric($_GET['min']) ? $_GET['min'] : 0;
$preco_max = isset($_GET['max']) && is_numeric($_GET['max']) ? $_GET['max'] : 999999;
$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'nome_asc';

// 2. Construir a query SQL de forma dinâmica
// O "WHERE 1=1" é um truque comum para facilitar a adição de múltiplos "AND"
$sql = "SELECT * FROM produtos WHERE 1=1";
$params = [];

// Filtro por nome ou descrição (LIKE)
if (!empty($busca)) {
    $sql .= " AND (nome LIKE :busca OR descricao LIKE :busca)";
    $params[':busca'] = '%' . $busca . '%';
}

// Filtro por faixa de preço (BETWEEN)
$sql .= " AND preco BETWEEN :min AND :max";
$params[':min'] = $preco_min;
$params[':max'] = $preco_max;

// Ordenação (ORDER BY)
switch ($ordem) {
    case 'preco_asc':
        $sql .= " ORDER BY preco ASC";
        break;
    case 'preco_desc':
        $sql .= " ORDER BY preco DESC";
        break;
    case 'nome_desc':
        $sql .= " ORDER BY nome DESC";
        break;
    default:
        $sql .= " ORDER BY nome ASC";
        break;
}

// 3. Preparar e executar a consulta
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao processar busca: " . $e->getMessage());
}
?>
