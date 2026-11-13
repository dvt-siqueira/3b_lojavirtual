<?php
date_default_timezone_set('America/Sao_Paulo');

$entrada = new DateTime('2025-11-12 09:00');
$saida = new DateTime('2025-11-12 17:00');

echo "--- REGISTRO DE PONTO ---\n";

echo "Entrada: " . $entrada->format('H:i') . "\n";
echo "Saída: " . $saida->format('H:i') . "\n";

if ($saida > $entrada) {
    $diferenca = $entrada->diff($saida);

    echo "Total trabalhado: ";
    echo $diferenca->h . " horas e ";
    echo $diferenca->i . " minutos.\n";
} else {
    echo "A saída deve ser posterior à entrada.\n";
}
?>
