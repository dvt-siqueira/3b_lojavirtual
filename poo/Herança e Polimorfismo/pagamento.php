<?php
interface MetodoPagamento{
    public function pagar(float $valor);
}
class CartaoCredito implements MetodoPagamento{
    public function pagar(float $valor){
        echo "Pagamento de R$ {$valor} feito com Cartão de Credito";
    }
}
class Pix implements MetodoPagamento{
    public function pagar(float $valor){
        echo "Pagamento de R$ {$valor} feito com pix";
    }
}
function processarVenda(MetodoPagamento $metodo, float $total){
    $metodo->pagar($total);
}

$compra1 = new CartaoCredito();
$compra2 = new Pix;
processarVenda($compra2,150.00);

?>