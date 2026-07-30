<?php
echo ("teste php");

$nomeAluno = "João";
$idadeAluno = 20;
$curso = "Programação Web";
echo "<br>Aluno: $nomeAluno,
<b>Idade:</b> $idadeAluno, Curso: $curso";

echo "<br><br><br>";
$nota1 = 8;
$nota2 = 6;
$media = ($nota1 + $nota2) / 2;
echo "A média do aluno é: $media";
echo "<br><br><br>";

$quantidadeEstoque = 0;
if ($quantidadeEstoque > 5 && $quantidadeEstoque <= 10) {
    echo "Produto disponível em estoque.";
} elseif ($quantidadeEstoque > 0 ) {
    echo "Produto com estoque baixo.";
} else {
    echo "Produto esgotado.";
}
