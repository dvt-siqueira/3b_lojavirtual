# EXERCÍCIOS DE REVISÃO - PROGRAMAÇÃO PARA INTERNET III (PHP)
## Aulas 01 a 03: Ambiente, Variáveis, Formulários e Estruturas de Controle

---

**Exercício 1 (Ambiente):**
Para testar um site desenvolvido em PHP localmente, precisamos de um servidor web.
a) Qual o nome do software que estamos utilizando para simular esse servidor (Apache + MySQL)?
b) Qual o endereço (URL) que digitamos no navegador para acessar os arquivos que estão dentro da pasta `htdocs`?

---

**Exercício 2 (Versionamento):**
Descreva a função de cada um dos comandos Git abaixo:
1. `git init`: __________________________________________________________________
2. `git add .`: _________________________________________________________________
3. `git commit -m "mensagem"`: __________________________________________________

---

**Exercício 3 (Variáveis e Concatenação):**
Crie um pequeno código PHP que declare duas variáveis: `$cidade` e `$estado`. Em seguida, use o operador de concatenação (`.`) para exibir a frase: "Eu moro em [cidade] - [estado].".

---

**Exercício 4 (Operadores Aritméticos):**
Qual será a saída do código abaixo?
```php
<?php
    $n1 = 10;
    $n2 = 2;
    $resultado = ($n1 + 30) / $n2;
    echo "O resultado é: " . $resultado;
?>
```
**Resposta:** __________________________________________________

---

**Exercício 5 (Formulários - GET vs POST):**
Explique a principal diferença visual na URL do navegador quando enviamos um formulário usando o método `method="get"` em comparação ao `method="post"`.

---

**Exercício 6 (Segurança):**
Ao receber dados de um formulário de cadastro, por que é uma boa prática utilizar a função `htmlspecialchars()` antes de exibir esses dados na tela?

---

**Exercício 7 (Estrutura Condicional):**
Complete o código abaixo para que ele verifique a idade de uma pessoa. Se a idade for 18 ou mais, exiba "Maior de idade". Caso contrário, exiba "Menor de idade".

```php
<?php
    $idade = 17;

    if (__________) {
        echo "Maior de idade";
    } __________ {
        echo "Menor de idade";
    }
?>
```

---

**Exercício 8 (Loops - While):**
Crie um laço `while` que conte de 10 até 1 (contagem regressiva) e imprima os números na tela.

---

**Exercício 9 (Arrays e Foreach):**
Dado o array abaixo, escreva o código PHP necessário para exibir cada cor em uma linha diferente.
`$cores = ["Vermelho", "Verde", "Azul", "Amarelo"];`

---

**Exercício 10 (Verificação de Variáveis):**
Qual função do PHP utilizamos para verificar se um campo de um formulário foi realmente enviado e não está nulo?
a) `empty()`
b) `count()`
c) `isset()`
d) `check()`

---
---