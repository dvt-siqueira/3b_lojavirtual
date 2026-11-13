
# Documentação Técnica: Integração do Carrinho de Compras

Esta documentação apresenta a estrutura arquitetural, os padrões de projeto e os conceitos de Programação Orientada a Objetos (POO) aplicados no módulo `carrinho.php` da **PI3 Store**.

---

## 1. Arquitetura e Padrão MVC

O módulo foi desenvolvido utilizando o padrão **MVC (Model-View-Controller)** para garantir a separação clara de responsabilidades.


```

```
   [ Usuário / Requisição ]
               │
               ▼
     ┌───────────────────┐
     │    carrinho.php   │ ──(Roteia Ação/Front-Controller)
     └─────────┬─────────┘
               │
┌──────────────┴──────────────┐
▼                             ▼

```

┌────────────────────────┐    ┌────────────────────────┐
│   CarrinhoController   │    │          View          │
│      (Controller)      │    │     (HTML / Render)    │
└───────────┬────────────┘    └────────────────────────┘
│
▼
┌────────────────────────┐
│     Regras de Negócio  │
│  (Carrinho / Produto)  │
└────────────────────────┘

```

* **Model (`models/`)**: Representa os dados e a lógica de negócio do sistema (`Produto`, `ItemCarrinho`, `Carrinho`).
* **Controller (`controllers/`)**: Atua como intermediário, recebendo as requisições, invocando as regras de negócio e preparando os dados para a interface.
* **View (`carrinho.php`)**: Responsável por renderizar a interface gráfica e apresentar as informações para o usuário.

---

## 2. Conceitos Importantes de POO

### Autoload Implicito via `require_once` e Ordem de Inicialização
Para preservar a integridade dos objetos serializados na sessão do PHP (`$_SESSION`), todas as definições das classes são importadas no topo da página antes da inicialização ou manipulação do estado da sessão pelo `CarrinhoController`.

```php
require_once __DIR__ . '/models/produtos.php';
require_once __DIR__ . '/models/ItemCarrinho.php';
require_once __DIR__ . '/models/Carrinho.php';
require_once __DIR__ . '/controllers/CarrinhoController.php';

```

### Separação entre Estoque e Quantidade do Item

Existe uma distinção clara entre o modelo de domínio do produto e o item do carrinho:

* **`Produto::$quantidadeEstoque`**: Controla o estoque total disponível no banco de dados.
* **`ItemCarrinho::$quantidade`**: Mantém a quantidade específica selecionada pelo cliente na sessão atual.

### Encapsulamento e Composição

O objeto `ItemCarrinho` encapsula uma instância de `Produto` combinada com a quantidade selecionada. O acesso aos dados é realizado por métodos acessores (`getters`):

```php
$item->getProduto()->getNome();$item->getProduto()->getPreco();
$item->getQuantidade();$item->getSubtotal();

```

---

## 3. Roteamento de Requisições HTTP (Verbos & Query Params)

O script trata requisições baseando-se nos métodos **POST** e **GET**, aplicando casting para sanitização de tipos primários (`(int)`):

```php
$acao =$_GET['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ações de alteração de estado (Adicionar, Atualizar)
    if ($acao === 'adicionar') {
        $produtoId = (int)($_POST['produto_id'] ?? 0);
        if ($produtoId > 0)$controller->adicionar($produtoId, 1); } elseif ($acao === 'atualizar') {
        $produtoId = (int)($_POST['produto_id'] ?? 0);
        $quantidade = (int)($_POST['quantidade'] ?? 1);
        if ($produtoId > 0)$controller->atualizar($produtoId,$quantidade);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ações via Link (Remover, Limpar)
    if ($acao === 'remover' && isset($_GET['id'])) {
        $controller->remover((int)$_GET['id']);
    } elseif ($acao === 'limpar') {$controller->limpar();
    }
}

```

---

## 4. Práticas de Segurança e Boas Práticas na View

### Sanitização de Dados contra XSS

Toda saída contendo dados dinâmicos gravados ou recuperados do banco/sessão passa pelo tratamento com `htmlspecialchars()`:

```php
<?= htmlspecialchars($item->getProduto()->getNome()) ?>

```

### Formatação Numérica Padrão BRL

Preços e totais utilizam `number_format()` para exibição adequada ao padrão monetário brasileiro:

```php
R$<?= number_format($item->getSubtotal(), 2, ',', '.') ?>

```

### Interface Reativa ao Estado (Empty State)

O código aplica renderização condicional baseada na contagem dos itens: se o array retornado por `$dados['itens']` estiver vazio, exibe o componente `cart-empty`; caso contrário, renderiza a estrutura completa da tabela e resumo de compra.

```

```