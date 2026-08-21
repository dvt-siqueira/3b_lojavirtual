<?php
class calc{
    private $result;

    public function __construct()
    {
        $this->result =0;
    }
public function soma($numero){
    $this->result += $numero;
}
public function subtracao($numero){
    $this->result-=$numero;
}
public function getResultado(){
return $this->result;
}

}

$c = new calc();
$c->soma(2);
$c->soma(4);
$c->subtracao(1);
echo "resultado: ". $c->getResultado();
