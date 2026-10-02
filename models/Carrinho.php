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
