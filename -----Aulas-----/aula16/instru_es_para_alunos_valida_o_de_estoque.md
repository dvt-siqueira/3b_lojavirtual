# 🛒 Atividade Prática: Validação de Estoque no Carrinho de Compras

Olá, pessoal!

Para aprimorar o nosso sistema de e-commerce, precisamos implementar uma regra de negócio fundamental: **validar se há estoque disponível no banco de dados antes de adicionar ou atualizar a quantidade de um produto no carrinho**.

Se não houver estoque suficiente, a operação deve ser **cancelada** e uma mensagem explicativa deve ser exibida ao usuário.

---

## 💡 Conceitos Importantes

Antes de ir para o código, vale relembrar dois pilares que orientam essa alteração:

1. **Separação de Responsabilidades (SRP - Single Responsibility Principle):**
   * A classe **`Carrinho`** representa o *domínio* do carrinho e sabe calcular e validar as quantidades que o usuário deseja comprar.
   * A classe **`CarrinhoController`** atua como *orquestradora*: ela consulta o banco de dados (via `Produto`), pede para o `Carrinho` validar e decide a navegação/redirecionamento do usuário.
2. **Diferença entre Adicionar vs. Atualizar:**
   * **Adicionar (Vitrine):** Se o usuário já possui 2 unidades de um item no carrinho e clica em "Comprar" (+1), a quantidade desejada final passa a ser **3**.
   * **Atualizar (Tabela do Carrinho):** Se o usuário digita **5** na tabela do carrinho e clica em atualizar, a quantidade final desejada é **5** (substitui o valor anterior).

---

## 🛠️ Onde Atuar e o que Modificar

Vocês farão alterações em **3 arquivos principais**:

```
├── models/
│   └── Carrinho.php             <-- [1] Criar novo método de validação
├── controllers/
│   └── CarrinhoController.php   <-- [2] Invocar validação nas ações
└── carrinhoVitrine.php          <-- [3] Exibir mensagem de aviso ao usuário
```

---

### 1️⃣ `models/Carrinho.php`
**O que fazer:** Criar o método `validarEstoque`.

Este método será responsável por checar se a quantidade total que o usuário quer colocar no carrinho ultrapassa o estoque retornado pelo banco (`$produto->getQdtEstoque()`).

```php
<?php
// Em: models/Carrinho.php

class Carrinho
{
    private array $itens = [];

    /**
     * Valida se o estoque do produto suporta a quantidade desejada.
     * 
     * @param Produto $produto Instância do produto vinda do banco de dados
     * @param int $quantidadeSolicitada Quantidade a ser adicionada ou alterada
     * @param bool $ehAtualizacao true para atualização na tabela; false para adição via vitrine
     * @return bool
     */
    public function validarEstoque(Produto $produto, int $quantidadeSolicitada, bool $ehAtualizacao = false): bool
    {
        $id = $produto->getId();
        $quantidadeAtualNoCarrinho = isset($this->itens[$id]) ? $this->itens[$id]->getQuantidade() : 0;

        // Se for atualização direta, usa a quantidade solicitada.
        // Se for adição, soma com o que já está no carrinho.
        $totalDesejado = $ehAtualizacao ? $quantidadeSolicitada : ($quantidadeAtualNoCarrinho + $quantidadeSolicitada);

        return $totalDesejado <= $produto->getQdtEstoque();
    }

    // ... Mantenha o restante do código original da classe (adicionar, remover, etc.)
}
```

---

### 2️⃣ `controllers/CarrinhoController.php`
**O que fazer:** Atualizar os métodos `adicionar()` e `atualizar()`.

No controlador, devemos buscar o produto atualizado no banco de dados com `Produto::buscarPorId()`, chamar o método `validarEstoque()` do carrinho e, caso falhe, interromper o fluxo enviando o erro via URL (`?erro=...`).

```php
<?php
// Em: controllers/CarrinhoController.php

class CarrinhoController
{
    // ... __construct e outros métodos permanecem iguais ...

    public function adicionar(int $produtoId, int $quantidade = 1): void
    {
        $produto = Produto::buscarPorId($produtoId);

        if ($produto) {
            $carrinho = $this->getCarrinho();

            // VALIDAÇÃO DE ESTOQUE (Adição: ehAtualizacao = false)
            if (!$carrinho->validarEstoque($produto, $quantidade, false)) {
                $msg = urlencode("Quantidade indisponível em estoque para {$produto->getNome()}. Disponível: {$produto->getQdtEstoque()}");
                header("Location: carrinhoVitrine.php?erro={$msg}");
                exit();
            }

            $item = new ItemCarrinho($produto, $quantidade);
            $carrinho->adicionar($item);
        }

        header('Location: carrinhoVitrine.php');
        exit();
    }

    public function atualizar(int $produtoId, int $quantidade): void
    {
        $produto = Produto::buscarPorId($produtoId);

        if ($produto) {
            $carrinho = $this->getCarrinho();

            // VALIDAÇÃO DE ESTOQUE (Atualização: ehAtualizacao = true)
            if (!$carrinho->validarEstoque($produto, $quantidade, true)) {
                $msg = urlencode("Não foi possível alterar para {$quantidade} unidade(s). Estoque disponível: {$produto->getQdtEstoque()}");
                header("Location: carrinhoVitrine.php?erro={$msg}");
                exit();
            }
        }

        $this->getCarrinho()->atualizarQuantidade($produtoId, $quantidade);
        header('Location: carrinhoVitrine.php');
        exit();
    }

    // ... Mantenha o restante dos métodos (remover, limpar, obterDadosView)
}
```

---

### 3️⃣ `carrinhoVitrine.php`
**O que fazer:** Tratar o parâmetro `GET['erro']` para informar o usuário.

Logo no início da página (logo após a chamada da Navbar), adicione o bloco que verifica se existe algum erro passado pela URL para exibir um alerta ao usuário:

```php
<!-- Em: carrinhoVitrine.php -->

<main class="container page-cart">
    
    <!-- EXIBIÇÃO DA MENSAGEM DE ERRO/ALERTA DE ESTOQUE -->
    <?php if (isset($_GET['erro'])): ?>
        <script>
            alert("<?= htmlspecialchars($_GET['erro']) ?>");
        </script>
    <?php endif; ?>

    <h2 class="cart-title">Seu Carrinho de Compras</h2>
    
    <!-- Restante da view mantido normalmente ... -->
```

---

## 🧪 Como Testar

1. Acesse o banco de dados e verifique a quantidade de um produto (ex: Produto ID 18 tem **10** unidades).
2. Tente adicionar **11** unidades ao carrinho ou atualizar o campo na tabela para **11**.
3. O sistema deve cancelar a operação e disparar a mensagem de aviso informando o estoque limite.