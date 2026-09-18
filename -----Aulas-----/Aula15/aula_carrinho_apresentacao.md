# 🎓 Aula Prática: Implementação do Carrinho de Compras em POO com PHP

> **Curso:** Programação para Internet  
> **Tópicos:** POO, Composição de Objetos, Encapsulamento, Controller e Sessão PHP (`$_SESSION`)

---

<!-- slide -->
## 🎯 Objetivos da Aula

* Compreender a **Composição de Objetos** em POO (relações entre instâncias).
* Aplicar o **Encapsulamento** com atributos privados e getters/setters.
* Evoluir a classe `Produto` para integração com o Banco de Dados.
* Gerenciar o estado da compra usando a **Sessão do PHP** (`$_SESSION`).
* Implementar o padrão **MVC** (Model - View - Controller).

---

<!-- slide -->
## 🗺️ Arquitetura do Sistema

```
lojaVirtual/
├── config.php                  # Conexão PDO
├── models/
│   ├── Produto.php             # Representa o produto (BD + Métodos)
│   ├── ItemCarrinho.php        # Produto + Quantidade (Composição)
│   └── Carrinho.php            # Coleção de ItemCarrinho
├── controllers/
│   └── CarrinhoController.php  # Regras de Negócio e Sessão
├── carrinho.php                # View / Interface do Carrinho
└── vitrine.php / index.php     # Exibição dos Produtos
```

---

<!-- slide -->
## 📍 Etapa 1: Evoluindo a Classe `Produto`

### O que mudou?
1. Atributos alterados de `public` para `private` (**Encapsulamento**).
2. Criação de métodos **Getters e Setters**.
3. Inclusão do método estático `buscarPorId(int $id)` para consulta PDO.

---

<!-- slide -->
### 💻 `models/Produto.php`

```php
<?php
// models/Produto.php

require_once __DIR__ . '/../config.php';

class Produto
{
    private ?int $id;
    private string $nome;
    private float $preco;
    private string $descricao;
    private string $foto;

    public function __construct(
        string $nome = '',
        float $preco = 0.0,
        string $descricao = '',
        string $foto = 'sem-foto.png',
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->descricao = $descricao;
        $this->foto = $foto;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getPreco(): float { return $this->preco; }
    public function getDescricao(): string { return $this->descricao; }
    public function getFoto(): string { return $this->foto; }

    // Busca do produto direto do Banco de Dados
    public static function buscarPorId(int $id): ?Produto
    {
        // Importa a conexão $pdo criada no config.php
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dados) {
            return null;
        }

        return new Produto(
            $dados['nome'],
            (float)$dados['preco'],
            $dados['descricao'] ?? '',
            $dados['foto'] ?? 'sem-foto.png',
            (int)$dados['id']
        );
    }
}
```

---

<!-- slide -->
### 🧪 Testando a Classe `Produto` (`teste_produto.php`)

```php
<?php
require_once 'models/Produto.php';

echo "<h2>🧪 Teste da Classe Produto</h2>";

// Teste manual de instanciação
$p1 = new Produto("Teclado Mecânico", 250.00, "RGB Switch Blue", "teclado.jpg", 1);

echo "Produto: " . $p1->getNome() . "<br>";
echo "Preço: R$ " . number_format($p1->getPreco(), 2, ',', '.') . "<br>";

// Teste do método estático (Requer Conexao e tabela 'produtos')
// $pBD = Produto::buscarPorId(1);
// var_dump($pBD);
```

---

<!-- slide -->
## 📍 Etapa 2: A Classe `ItemCarrinho`

### Conceito: Composição de Objetos
Um `ItemCarrinho` representa a união entre **um objeto `Produto`** e a **quantidade** selecionada pelo cliente.

$$	ext{Subtotal} = 	ext{Preço do Produto} 	imes 	ext{Quantidade}$$

---

<!-- slide -->
### 💻 `models/ItemCarrinho.php`

```php
<?php
require_once __DIR__ . '/Produto.php';

class ItemCarrinho
{
    private Produto $produto;
    private int $quantidade;

    public function __construct(Produto $produto, int $quantidade = 1)
    {
        $this->produto = $produto;
        $this->quantidade = $quantidade;
    }

    public function getProduto(): Produto { return $this->produto; }
    public function getQuantidade(): int { return $this->quantidade; }
    public function setQuantidade(int $quantidade): void { $this->quantidade = $quantidade; }

    // Subtotal calculado em tempo de execução
    public function getSubtotal(): float
    {
        return $this->produto->getPreco() * $this->quantidade;
    }
}
```

---

<!-- slide -->
### 🧪 Testando o `ItemCarrinho` (`teste_item.php`)

```php
<?php
require_once 'models/Produto.php';
require_once 'models/ItemCarrinho.php';

echo "<h2>🧪 Teste do ItemCarrinho</h2>";

$p1 = new Produto("Mouse Gamer", 150.00, "16000 DPI", "mouse.jpg", 2);
$item = new ItemCarrinho($p1, 3); // 3 unidades

echo "Produto: " . $item->getProduto()->getNome() . "<br>";
echo "Quantidade: " . $item->getQuantidade() . "<br>";
echo "Preço Unitário: R$ " . number_format($item->getProduto()->getPreco(), 2, ',', '.') . "<br>";
echo "<strong>Subtotal: R$ " . number_format($item->getSubtotal(), 2, ',', '.') . "</strong>";
```

---

<!-- slide -->
## 📍 Etapa 3: A Classe `Carrinho`

### Responsabilidades da Classe
* Manter a coleção de instâncias de `ItemCarrinho`.
* Adicionar novos itens (ou somar quantidades de itens já existentes).
* Remover e atualizar quantidades de itens.
* Calcular o valor total acumulado do carrinho.

---

<!-- slide -->
### 💻 `models/Carrinho.php`

```php
<?php
require_once __DIR__ . '/ItemCarrinho.php';

class Carrinho
{
    private array $itens = [];

    public function adicionar(ItemCarrinho $item): void
    {
        $id = $item->getProduto()->getId();

        if (isset($this->itens[$id])) {
            $novaQtd = $this->itens[$id]->getQuantidade() + $item->getQuantidade();
            $this->itens[$id]->setQuantidade($novaQtd);
        } else {
            $this->itens[$id] = $item;
        }
    }

    public function remover(int $produtoId): void
    {
        unset($this->itens[$produtoId]);
    }

    public function atualizarQuantidade(int $produtoId, int $quantidade): void
    {
        if (isset($this->itens[$produtoId])) {
            if ($quantidade > 0) {
                $this->itens[$produtoId]->setQuantidade($quantidade);
            } else {
                $this->remover($produtoId);
            }
        }
    }

    public function calcularTotal(): float
    {
        $total = 0.0;
        foreach ($this->itens as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }

    public function getQuantidadeTotal(): int
    {
        $qtd = 0;
        foreach ($this->itens as $item) {
            $qtd += $item->getQuantidade();
        }
        return $qtd;
    }

    public function getItens(): array { return $this->itens; }
    public function limpar(): void { $this->itens = []; }
}
```

---

<!-- slide -->
### 🧪 Testando o `Carrinho` (`teste_carrinho.php`)

```php
<?php
require_once 'models/Produto.php';
require_once 'models/ItemCarrinho.php';
require_once 'models/Carrinho.php';

echo "<h2>🧪 Teste da Coleção Carrinho</h2>";

$p1 = new Produto("Teclado Mecânico", 200.00, "", "", 1);
$p2 = new Produto("Monitor 144Hz", 1200.00, "", "", 2);

$carrinho = new Carrinho();
$carrinho->adicionar(new ItemCarrinho($p1, 1));
$carrinho->adicionar(new ItemCarrinho($p2, 2));

// Adicionando o mesmo produto para testar a soma de quantidades
$carrinho->adicionar(new ItemCarrinho($p1, 2)); 

echo "<pre>";
print_r($carrinho->getItens());
echo "</pre>";

echo "Total de Itens: " . $carrinho->getQuantidadeTotal() . "<br>";
echo "<strong>Valor Total: R$ " . number_format($carrinho->calcularTotal(), 2, ',', '.') . "</strong>";
```

---

<!-- slide -->
## 📍 Etapa 4: O Controlador e a Sessão PHP

### ⚠️ Regra Crítica de POO com Sessão no PHP
> As classes de modelo (`ItemCarrinho.php` e `Carrinho.php`) **DEVEM ser importadas (`require_once`) ANTES de executar o `session_start()`**.
>
> Caso contrário, ao desserializar o objeto em `$_SESSION['carrinho']`, o PHP emitirá um erro fatal de `__PHP_Incomplete_Class`.

---

<!-- slide -->
### 💻 `controllers/CarrinhoController.php`

```php
<?php
// 1. OBRIGATÓRIO: Carregar as classes ANTES de iniciar a sessão!
require_once __DIR__ . '/../models/ItemCarrinho.php';
require_once __DIR__ . '/../models/Carrinho.php';
require_once __DIR__ . '/../models/Produto.php';

class CarrinhoController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['carrinho']) || !($_SESSION['carrinho'] instanceof Carrinho)) {
            $_SESSION['carrinho'] = new Carrinho();
        }
    }

    private function getCarrinho(): Carrinho
    {
        return $_SESSION['carrinho'];
    }

    public function adicionar(int $produtoId, int $quantidade = 1): void
    {
        $produto = Produto::buscarPorId($produtoId);
        if ($produto) {
            $item = new ItemCarrinho($produto, $quantidade);
            $this->getCarrinho()->adicionar($item);
        }
        header('Location: carrinho.php');
        exit();
    }

    public function remover(int $produtoId): void
    {
        $this->getCarrinho()->remover($produtoId);
        header('Location: carrinho.php');
        exit();
    }

    public function atualizar(int $produtoId, int $quantidade): void
    {
        $this->getCarrinho()->atualizarQuantidade($produtoId, $quantidade);
        header('Location: carrinho.php');
        exit();
    }

    public function limpar(): void
    {
        $this->getCarrinho()->limpar();
        header('Location: carrinho.php');
        exit();
    }

    public function obterDadosView(): array
    {
        $carrinho = $this->getCarrinho();
        return [
            'itens' => $carrinho->getItens(),
            'total' => $carrinho->calcularTotal(),
            'quantidadeTotal' => $carrinho->getQuantidadeTotal()
        ];
    }
}
```

---

<!-- slide -->
## 📍 Etapa 5: Interface do Carrinho (`carrinho.php`)

### Integração com a Controller

```php
<?php
require_once 'models/ItemCarrinho.php';
require_once 'models/Carrinho.php';
require_once 'controllers/CarrinhoController.php';

$controller = new CarrinhoController();
$acao = $_GET['acao'] ?? 'exibir';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $acao === 'adicionar') {
    $id = (int)$_POST['produto_id'];
    $qtd = (int)$_POST['quantidade'];
    $controller->adicionar($id, $qtd);
} elseif ($acao === 'remover') {
    $id = (int)$_GET['id'];
    $controller->remover($id);
} elseif ($acao === 'atualizar') {
    $id = (int)$_POST['produto_id'];
    $qtd = (int)$_POST['quantidade'];
    $controller->atualizar($id, $qtd);
} elseif ($acao === 'limpar') {
    $controller->limpar();
}

$dados = $controller->obterDadosView();
?>
```

---

<!-- slide -->
### 💻 HTML / Rendering (`carrinho.php`)

```html
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Seu Carrinho de Compras</h1>

    <?php if (empty($dados['itens'])): ?>
        <p>Seu carrinho está vazio! <a href="index.php">Voltar às compras</a></p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados['itens'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->getProduto()->getNome()) ?></td>
                        <td>R$ <?= number_format($item->getProduto()->getPreco(), 2, ',', '.') ?></td>
                        <td>
                            <form action="carrinho.php?acao=atualizar" method="POST" style="display:inline;">
                                <input type="hidden" name="produto_id" value="<?= $item->getProduto()->getId() ?>">
                                <input type="number" name="quantidade" value="<?= $item->getQuantidade() ?>" min="1">
                                <button type="submit">Atualizar</button>
                            </form>
                        </td>
                        <td>R$ <?= number_format($item->getSubtotal(), 2, ',', '.') ?></td>
                        <td>
                            <a href="carrinho.php?acao=remover&id=<?= $item->getProduto()->getId() ?>">Remover</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total da Compra: R$ <?= number_format($dados['total'], 2, ',', '.') ?></h3>

        <a href="carrinho.php?acao=limpar">Esvaziar Carrinho</a> | 
        <a href="index.php">Continuar Comprando</a>
    <?php endif; ?>
</body>
</html>
```

---

<!-- slide -->
## 📌 Resumo & Boas Práticas

1. **Encapsulamento:** Proteger atributos das classes (`private`) e expor dados via métodos.
2. **Composição de Objetos:** `Carrinho` possui `ItemCarrinho`, que possui `Produto`.
3. **Persistência Temporária:** Utilizar a sessão (`$_SESSION`) para salvar objetos entre requisições.
4. **Desserialização PHP:** Sempre fazer o `require_once` das classes de modelo **antes** do `session_start()`.
