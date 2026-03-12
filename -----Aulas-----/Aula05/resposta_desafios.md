# 🎯 Respostas dos Desafios — Aula 05

Aqui estão as sugestões de código para resolver os desafios propostos na Aula 05.

---

## Desafio 1: Ordenação Personalizada
Para ordenar os produtos do mais caro para o mais barato, basta alterar a cláusula `ORDER BY` no comando SQL dentro do arquivo `listar.php`.

**Código alterado:**
```php
$sql = "SELECT * FROM produtos ORDER BY preco DESC";
```

---

## Desafio 2: Filtro de Busca (Extra)
Este desafio exige a adição de um formulário HTML e a alteração da lógica PHP para filtrar os resultados usando `LIKE` e `prepare()`.

**Exemplo de implementação no `listar.php`:**

```php
<!-- 1. Formulário de Busca (HTML) -->
<form method="GET" action="listar.php" style="margin-bottom: 20px;">
    <input type="text" name="busca" placeholder="Buscar produto..." value="<?php echo $_GET['busca'] ?? ''; ?>">
    <button type="submit">Pesquisar</button>
</form>

<?php
// 2. Lógica PHP alterada
$busca = $_GET['busca'] ?? '';

if ($busca != '') {
    // Se houver uma busca, filtra usando LIKE
    $sql = "SELECT * FROM produtos WHERE nome LIKE :busca ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':busca' => "%$busca%"]);
} else {
    // Se não houver busca, traz tudo
    $sql = "SELECT * FROM produtos ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
}

$produtos = $stmt->fetchAll();
?>
```

---

## Desafio 3: Contador de Itens
Para exibir o total de produtos, utilizamos a função `count()` do PHP no array `$produtos` que retornou do banco.

**Exemplo de código:**
```php
<p>Total de produtos cadastrados: <strong><?php echo count($produtos); ?></strong></p>
```

Coloque este código logo acima da tag `<table>` no seu arquivo `listar.php`.
