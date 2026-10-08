<?php
// 1. OBRIGATÓRIO: Carregar as classes ANTES de iniciar a sessão!
require_once __DIR__ . '/../models/ItemCarrinho.php';
require_once __DIR__ . '/../models/Carrinho.php';
require_once __DIR__ . '/../models/Produtos.php';

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
        header('Location: carrinhoVitrine.php');
        exit();
    }

    public function remover(int $produtoId): void
    {
        $this->getCarrinho()->remover($produtoId);
        header('Location: carrinhoVitrine.php');
        exit();
    }

    public function atualizar(int $produtoId, int $quantidade): void
    {
        $this->getCarrinho()->atualizarQuantidade($produtoId, $quantidade);
        header('Location: carrinhoVitrine.php');
        exit();
    }

    public function limpar(): void
    {
        $this->getCarrinho()->limpar();
        header('Location: carrinhoVitrine.php');
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
