<?php    
class Produto{
    private $preco;
    public function setPreco($preco)
    {
        if ($preco < 0) {
            throw new Exception("Preço não pode ser negativo");
        }   
        $this->preco = $preco;
    }
    public function getPreco()
    {
        return $this->preco;
    }   
}
$prd = new Produto();
$prd->setPreco(-30);
echo $prd->getPreco(); // 100
?>