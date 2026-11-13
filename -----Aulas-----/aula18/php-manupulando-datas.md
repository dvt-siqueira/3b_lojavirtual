# Manipulação de Datas e Horários em PHP

**Tópicos:** Timestamp Unix, `time()`, `date()`, `strtotime()`,
`mktime()`, `checkdate()`, `DateTime`, `DateTimeImmutable`,
`DateTimeZone` e `DateInterval`.

------------------------------------------------------------------------

## 🎯 Objetivos da Aula

-   Compreender o conceito de Timestamp Unix e sua utilização na
    representação computacional de datas e horários.
-   Aplicar funções procedurais do PHP, como `time()`, `date()`,
    `strtotime()`, `mktime()` e `checkdate()`, para obter, formatar,
    converter, construir e validar datas.
-   Criar e manipular objetos utilizando as classes `DateTime` e
    `DateTimeImmutable`, reconhecendo as diferenças entre objetos
    mutáveis e imutáveis.
-   Converter datas em formatos personalizados utilizando
    `createFromFormat()`.
-   Configurar fusos horários utilizando `DateTimeZone` e
    `date_default_timezone_set()`.
-   Criar intervalos, comparar datas e calcular diferenças entre
    horários utilizando `DateInterval`, `diff()` e operadores
    relacionais.

------------------------------------------------------------------------

## Apresentação

A manipulação de datas e horários é necessária em aplicações como
sistemas de controle de ponto, agendamentos, emissão de relatórios e
registros de operações. Em PHP, esse trabalho pode ser realizado
inicialmente com funções procedurais e, conforme a necessidade da
aplicação aumenta, com classes orientadas a objetos.

A manipulação de datas será apresentada de forma progressiva, por meio
de um único script PHP. Cada etapa acrescenta um recurso ao programa,
mostrando como as funções e classes podem ser utilizadas na construção
de uma aplicação.

## Percurso Didático --- Construção Progressiva do Código

### Etapa 1 --- Como o PHP representa o tempo?

**Conceitos:** Timestamp Unix, Era Unix e função `time()`.

o Timestamp Unix representa a quantidade de segundos transcorridos desde
1º de janeiro de 1970, às 00:00:00 UTC. O PHP utiliza esse valor para
representar um instante no tempo.

Comece o código no projetor:

``` php
<?php
$timestamp = time();

echo $timestamp;
?>
```

O valor retornado representa a quantidade de segundos desde 1º de
janeiro de 1970. Ao executar o código novamente após alguns segundos, o
timestamp será maior.

O mesmo instante pode ser apresentado de forma legível utilizando
`date()`.

### Etapa 2 --- Transformando o timestamp em uma data legível

**Conceitos:** função `date()` e especificadores de formatação.

A função `date($format, $timestamp)` transforma um timestamp em uma
string formatada. O segundo parâmetro é opcional; quando omitido, o PHP
utiliza o instante atual.

Evolua o código anterior:

``` php
<?php
$timestamp = time();

echo date('d/m/Y H:i:s', $timestamp);
?>
```

Principais especificadores de formatação:

  Especificador   Significado                           Exemplo
  --------------- ------------------------------------- ------------
  `d`             Dia do mês com dois dígitos           `05`
  `m`             Mês numérico com dois dígitos         `11`
  `Y`             Ano com quatro dígitos                `2026`
  `y`             Ano com dois dígitos                  `26`
  `H`             Hora no formato 24 horas              `14`
  `i`             Minutos                               `30`
  `s`             Segundos                              `45`
  `l`             Dia da semana por extenso em inglês   `Thursday`

Os formatos podem ser alterados para apresentar diferentes partes da
data e do horário:

``` php
echo date('d/m/Y');
echo date('H:i');
echo date('l');
```

os especificadores diferenciam maiúsculas de minúsculas: `m` representa
mês, enquanto `i` representa minutos. Para exibir caracteres literais
que poderiam ser interpretados como especificadores, utiliza-se a barra
invertida como escape.

### Etapa 3 --- Trabalhando com datas futuras e expressões relativas

**Conceito:** função `strtotime()`.

A função é utilizada para calcular datas futuras ou passadas sem
realizar manualmente operações com dias e meses.

O código atualizado fica assim:

``` php
<?php
$timestamp = time();

echo "Data atual: " . date('d/m/Y', $timestamp) . "\n";

$proximaSemana = strtotime('+1 week');
echo "Daqui a uma semana: " . date('d/m/Y', $proximaSemana) . "\n";

$mesAnterior = strtotime('-1 month');
echo "Um mês atrás: " . date('d/m/Y', $mesAnterior) . "\n";
?>
```

`strtotime()` interpreta expressões de data e horário em inglês e
retorna um timestamp Unix. Mostre outras expressões que podem ser
testadas:

-   `+1 day`
-   `+1 month`
-   `next Thursday`
-   `last Monday`

Expressões relativas envolvendo meses podem produzir resultados
diferentes conforme a data de referência, pois os meses possuem
quantidades distintas de dias.

### Etapa 4 --- Construindo datas com valores numéricos

**Conceito:** função `mktime()`.

também é possível construir um timestamp informando separadamente os
componentes da data e do horário.

Acrescente:

``` php
<?php
$timestampEvento = mktime(14, 30, 0, 8, 15, 2025);

echo date('d/m/Y H:i:s', $timestampEvento);
?>
```

A ordem dos parâmetros é:

``` php
mktime($hora, $minuto, $segundo, $mes, $dia, $ano);
```

Para representar 20 de dezembro de 2025, às 8h15, os parâmetros devem
ser informados na seguinte ordem: hora `8`, minuto `15`, segundo `0`,
mês `12`, dia `20` e ano `2025`.

### Etapa 5 --- Validando datas antes de utilizá-las

**Conceito:** função `checkdate()`.

Apresente uma situação comum: um formulário recebe dia, mês e ano
digitados pelo usuário. Antes de utilizar esses valores, é necessário
verificar se representam uma data válida.

``` php
<?php
$dia = 31;
$mes = 4;
$ano = 2024;

if (checkdate($mes, $dia, $ano)) {
    echo "Data válida.";
} else {
    echo "Data inválida.";
}
?>
```

`checkdate($mes, $dia, $ano)` verifica a validade da data no calendário
gregoriano e retorna `true` ou `false`.

**Exemplos de validação:**

-   `31/04/2024`: data inválida.
-   `29/02/2024`: data válida.
-   `29/02/2023`: data inválida.

A alteração dos valores permite verificar como a função identifica datas
válidas e inválidas.

------------------------------------------------------------------------

### Etapa 6 --- Evoluindo das funções para os objetos

**Conceitos:** orientação a objetos e classe `DateTime`.

as funções procedurais permitem obter, formatar, converter e validar
datas. 

O código inicial é:

``` php
<?php
$dataAtual = new DateTime();

echo $dataAtual->format('d/m/Y H:i:s');
?>
```

`new DateTime()` cria um objeto com a data e o horário atuais e que o
método `format()` realiza a apresentação dos dados.

Uma data específica pode ser criada informando seu valor ao instanciar o
objeto:

``` php
<?php
$data = new DateTime('2025-12-25');

echo $data->format('d/m/Y');
?>
```

o objeto também pode ser alterado com métodos como `modify()`, `add()` e
`sub()`.

``` php
<?php
$data = new DateTime('2025-12-25');

$data->modify('+1 day');
echo $data->format('d/m/Y');
//P de Periodo e M de meses para tempo use T apos o Periodo
$data->add(new DateInterval('P5M'));
echo $data->format('d/m/Y');

$data->sub(new DateInterval('P5D'));
echo $data->format('d/m/Y');

?>
```

O próprio objeto é modificado.

### Etapa 7 --- Recebendo datas em formatos brasileiros

**Conceito:** método `createFromFormat()`.

formulários frequentemente recebem datas no formato brasileiro
`DD/MM/AAAA`, enquanto a aplicação pode precisar interpretar esse valor
em um formato específico.

O exemplo a seguir demonstra:

``` php
<?php
$dataTexto = '25/12/2025';

$data = DateTime::createFromFormat('d/m/Y', $dataTexto);

if ($data !== false) {
    echo $data->format('Y');
} else {
    echo "Não foi possível interpretar a data.";
}
?>
```

Parâmetros do método:

-   Primeiro parâmetro: formato esperado para a entrada.
-   Segundo parâmetro: texto que será convertido.

`createFromFormat()` pode retornar `false` quando não consegue criar o
objeto. Em aplicações reais, também é importante verificar avisos e
erros de análise com `DateTime::getLastErrors()` quando a validação
precisa ser rigorosa.

### Etapa 8 --- Entendendo a diferença entre `DateTime` e `DateTimeImmutable`

**Conceitos:** mutabilidade e imutabilidade.

* `DateTime` altera o próprio
objeto:

``` php
<?php
$data = new DateTime('2025-12-25');

$data->modify('+1 day');

echo $data->format('d/m/Y');
?>
```

 `DateTimeImmutable` não altera a instância do objeto:

``` php
<?php
$data = new DateTimeImmutable('2025-12-25');

$novaData = $data->modify('+1 day');

echo "Original: " . $data->format('d/m/Y') . "\n";
echo "Nova data: " . $novaData->format('d/m/Y');
?>
```

**Diferenças entre as classes:**

-   `DateTime`: as alterações modificam a instância existente.
-   `DateTimeImmutable`: as alterações retornam uma nova instância,
    preservando o objeto original.

Reforce que a imutabilidade ajuda a evitar alterações acidentais em
datas compartilhadas por diferentes partes de uma aplicação.

### Etapa 9 --- Configurando o fuso horário

**Conceitos:** `DateTimeZone` e `date_default_timezone_set()`.

o servidor pode estar configurado em um fuso horário diferente daquele
utilizado pelos usuários da aplicação. Isso pode provocar diferenças na
exibição de datas e horários.

A configuração global do fuso horário é feita assim:

``` php
<?php
date_default_timezone_set('America/Sao_Paulo');

echo date('d/m/Y H:i:s');
?>
```

O fuso horário também pode ser definido diretamente no objeto:

``` php
<?php
$fuso = new DateTimeZone('America/Sao_Paulo');

$data = new DateTime('now', $fuso);

echo $data->format('d/m/Y H:i:s');
?>
```

`DateTimeZone` representa um fuso horário e pode ser associado
diretamente a um objeto de data.

Uma aplicação utilizada no Brasil precisa considerar o fuso horário para
registrar corretamente horários de entrada, saída e agendamentos,
evitando diferenças causadas pela configuração do servidor.

### Etapa 10 --- Calculando intervalos e diferenças entre horários

**Conceitos:** `DateInterval` e método `diff()`.

Apresente uma situação prática: um sistema precisa calcular quanto tempo
um funcionário permaneceu trabalhando entre a entrada e a saída.

Os dois horários são criados da seguinte forma:

``` php
<?php
date_default_timezone_set('America/Sao_Paulo');

$entrada = new DateTime('2025-11-12 09:00');
$saida = new DateTime('2025-11-12 18:30');

echo $entrada->format('H:i') . "\n";
echo $saida->format('H:i');
?>
```

O cálculo da diferença é realizado com `diff()`:

``` php
<?php
date_default_timezone_set('America/Sao_Paulo');

$entrada = new DateTime('2025-11-12 09:00');
$saida = new DateTime('2025-11-12 18:30');

$diferenca = $entrada->diff($saida);

echo "Total: " . $diferenca->h . " horas e ";
echo $diferenca->i . " minutos.";
?>
```

`diff()` retorna um objeto `DateInterval`, que armazena os componentes
da diferença entre as datas.

Principais propriedades:

  Propriedade   Significado
  ------------- ----------------------------------
  `y`           Anos
  `m`           Meses
  `d`           Dias
  `h`           Horas
  `i`           Minutos
  `s`           Segundos
  `days`        Total de dias, quando disponível

**Atenção:** para diferenças que atravessam dias, meses ou anos, não
basta exibir somente `h` e `i`. essas propriedades representam
componentes do intervalo. Para obter uma duração total em horas, é
necessário considerar também os dias.

### Etapa 11 --- Criando intervalos manualmente

**Conceito:** classe `DateInterval`.

também é possível criar um intervalo sem calcular a diferença entre duas
datas.

``` php
<?php
$intervalo = new DateInterval('P1D');

$data = new DateTimeImmutable('2025-12-25');

$novaData = $data->add($intervalo);

echo $novaData->format('d/m/Y');
?>
```

A notação de período utiliza os seguintes formatos:

-   `P1D`: período de 1 dia.
-   `PT3H`: período de 3 horas.
-   `P2DT5H`: período de 2 dias e 5 horas.

a letra `T` separa as unidades de tempo (horas, minutos e segundos) das
unidades de calendário.

### Etapa 12 --- Comparando datas

**Conceito:** operadores relacionais com objetos de data.

objetos `DateTime` podem ser comparados com operadores relacionais.

``` php
<?php
$dataInicial = new DateTime('2025-11-10');
$dataFinal = new DateTime('2025-11-15');

if ($dataFinal > $dataInicial) {
    echo "A data final é posterior à data inicial.";
} else {
    echo "A data final não é posterior à data inicial.";
}
?>
```

Os operadores `>`, `<` e `==` permitem verificar a ordem cronológica
entre as datas. A alteração dos valores permite testar diferentes
situações.

------------------------------------------------------------------------

## Desafio Prático Integrador --- Registro de Ponto

**Objetivo:** reunir os principais recursos apresentados durante a
construção progressiva do código.

**Enunciado:** desenvolva um script PHP que represente o registro de
ponto de um funcionário. O programa deverá:

1.  Configurar o fuso horário para `America/Sao_Paulo`.
2.  Criar objetos que representem a entrada às 09h00 e a saída às 18h30
    de uma data definida.
3.  Exibir os horários registrados no formato `HH:MM`.
4.  Utilizar `diff()` para calcular o intervalo entre a entrada e a
    saída.
5.  Exibir a quantidade de horas e minutos do intervalo.
6.  Verificar, utilizando operadores relacionais, se a saída ocorreu
    depois da entrada.

**Solução esperada:**

``` php
<?php
date_default_timezone_set('America/Sao_Paulo');

$entrada = new DateTime('2025-11-12 09:00');
$saida = new DateTime('2025-11-12 18:30');

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
```

**Questões sobre o funcionamento do sistema:**

-   O que aconteceria se a saída fosse registrada antes da entrada?
-   Como o sistema poderia validar uma data digitada pelo usuário?
-   Por que utilizar `DateTimeImmutable` poderia ser interessante em uma
    aplicação maior?
-   Como adaptar o programa para calcular uma jornada que atravessa a
    meia-noite?

------------------------------------------------------------------------

## Síntese dos Recursos de Manipulação de Datas

  -----------------------------------------------------------------------
  Recurso                 Paradigma               Finalidade principal
  ----------------------- ----------------------- -----------------------
  `time()`                Procedural              Obter o timestamp Unix
                                                  atual.

  `date()`                Procedural              Formatar e exibir data
                                                  e horário.

  `strtotime()`           Procedural              Converter expressões de
                                                  data e horário em
                                                  timestamp.

  `mktime()`              Procedural              Construir timestamp a
                                                  partir de valores
                                                  numéricos.

  `checkdate()`           Procedural              Validar uma data do
                                                  calendário gregoriano.

  `DateTime`              Orientado a Objetos     Criar e manipular
                                                  objetos de data e hora
                                                  mutáveis.

  `DateTimeImmutable`     Orientado a Objetos     Manipular datas sem
                                                  alterar o objeto
                                                  original.

  `createFromFormat()`    Orientado a Objetos     Interpretar datas em
                                                  formatos definidos.

  `DateTimeZone`          Orientado a Objetos     Representar e
                                                  configurar fusos
                                                  horários.

  `DateInterval`          Orientado a Objetos     Representar intervalos
                                                  de tempo.

  `diff()`                Orientado a Objetos     Calcular a diferença
                                                  entre dois objetos de
                                                  data.

  Operadores relacionais  Orientado a Objetos     Comparar
                                                  cronologicamente
                                                  objetos de data.
  -----------------------------------------------------------------------

------------------------------------------------------------------------

## Orientações para a Condução da Aula

1.  **Construção gradual:** o código é desenvolvido em um único arquivo
    PHP, com cada etapa acrescentando um novo recurso.
2.  **Experimentação:** datas, horários, formatos e parâmetros podem ser
    alterados para observar os efeitos de cada função e método.
3.  **Comparação entre paradigmas:** as funções procedurais e a
    orientação a objetos oferecem abordagens diferentes para manipular
    datas.
4.  **Atenção aos formatos:** `m` representa mês e `i` representa
    minutos; `Y` representa o ano com quatro dígitos e `y`, com dois
    dígitos.
5.  **Validação:** entradas recebidas de formulários devem ser validadas
    antes de serem utilizadas.
6.  **Aplicação profissional:** os recursos apresentados podem ser
    utilizados em sistemas de controle de ponto, agendamentos,
    vencimentos e emissão de relatórios.

**Síntese:** o código conecta os conceitos apresentados, evoluindo de
operações simples com timestamps até uma aplicação prática de
manipulação de datas e horários.
