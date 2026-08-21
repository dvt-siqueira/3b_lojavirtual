# Caderno de Atividades Práticas: Programação Orientada a Objetos em PHP

Este caderno de atividades foi desenvolvido para guiar você no aprendizado dos conceitos fundamentais de **Programação Orientada a Objetos (POO)** utilizando a linguagem **PHP**. Os exercícios abordam desde a criação básica de classes e objetos até o conceito crucial de **Encapsulamento** (uso de modificadores de visibilidade privados, métodos construtores, getters, setters e validações).

---

## Exercício 1 (Exemplo Resolvido): Classe `Student` com Encapsulamento

**Objetivo:** Compreender a estrutura de uma classe com atributos privados, método construtor, métodos de acesso (getters/setters) e método de exibição de dados.

### Código de Exemplo:
```php
<?php

class Student {
    // Atributos privados (Encapsulamento)
    private $name;
    private $age;
    private $grade;

    // Método Construtor para inicializar as propriedades
    public function __construct($name, $age, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
    }


    // Método para exibir as informações do estudante
    public function displayInfo() {
        echo "Nome: " . $this->name . "<br>";
        echo "Idade: " . $this->age . "<br>";
        echo "Nota/Série: " . $this->grade . "<br>";
    }
}

// Instanciação (Criação do objeto) e teste da classe
$student = new Student("Andrea", 16, 10);
$student->displayInfo();

?>
```

### Explicação do Modelo:
* **Atributos Privados (`private`):** As propriedades `$name`, `$age` e `$grade` são declaradas como privadas. Isso significa que elas não podem ser acessadas diretamente de fora da classe (por exemplo, `$student->name = "Novo Nome"` gerará um erro). O acesso direto é bloqueado para proteger a integridade dos dados.
* **Método Construtor (`__construct`):** É executado automaticamente quando criamos um novo objeto com a palavra-chave `new`. Ele recebe os valores iniciais como parâmetros e os atribui aos atributos privados da instância usando `$this->`.
* **Comportamento do Método `displayInfo()`:** Exibe de forma formatada as informações do aluno na tela utilizando os atributos internos da própria classe através do operador de seta (`$this->`).

---

## Exercício 2: Classe `Vehicle` (Carro)

**Instruções para o Aluno:**
Crie uma classe chamada `Vehicle` contendo os atributos privados `brand`, `model` e `year`. Implemente o método construtor para inicializar as propriedades e um método chamado `displayDetails()` para mostrar as informações do carro na tela. Instancie um objeto representativo (ex: Ford F-150, ano 2020) e chame o método de exibição.

### Explicação do Modelo para Criação:
* **Atributos Privados:** 
  * `private $brand` (marca do veículo).
  * `private $model` (modelo do veículo).
  * `private $year` (ano de fabricação).
* **Método Construtor:**
  * O método `__construct($brand, $model, $year)` deve receber três parâmetros para inicializar todos os atributos criados de forma imediata na instanciação.
* **Comportamento do Método `displayDetails()`:**
  * Deve imprimir no console ou no navegador os valores de marca, modelo e ano concatenados com quebras de linha (`<br>`).

---

## Exercício 3: Classe `Calculator` (Calculadora Básica)

**Instruções para o Aluno:**
Escreva uma classe em PHP chamada `Calculator` que possua uma propriedade privada chamada `result`, a qual deve ser inicializada com `0` no construtor. Implemente métodos públicos para realizar operações aritméticas básicas de soma (`add`) e subtração (`subtract`), que atualizam diretamente o valor desse atributo encapsulado. Crie também o método `getResult()` para consultar o saldo final calculado.

### Explicação do Modelo para Criação:
* **Atributos Privados:**
  * `private $result` (armazena o resultado acumulado dos cálculos).
* **Método Construtor:**
  * O construtor `__construct()` não deve receber parâmetros; em vez disso, deve apenas definir o valor inicial de `$this->result` como `0`.
* **Comportamento dos Métodos:**
  * `add($number)`: Adiciona o número recebido por parâmetro ao atributo `$result` (`$this->result += $number`).
  * `subtract($number)`: Subtrai o número recebido por parâmetro do atributo `$result` (`$this->result -= $number`).
  * `getResult()`: Método getter público que simplesmente retorna o valor contido em `$result`.

---

## Exercício 4: Classe `ShoppingCart` (Carrinho de Compras)

**Instruções para o Aluno:**
Escreva uma classe chamada `ShoppingCart` para gerenciar itens em um comércio eletrônico. A classe deve conter as propriedades privadas `items` (um array associativo que armazenará o nome do produto como chave e seu respectivo preço como valor) e `total` (que armazena a soma acumulada dos valores). Crie métodos para adicionar itens ao carrinho e retornar o custo total final.

### Explicação do Modelo para Criação:
* **Atributos Privados:**
  * `private $items` (array para salvar os nomes dos produtos e seus preços).
  * `private $total` (numérico decimal para armazenar o valor da compra).
* **Método Construtor:**
  * O método `__construct()` deve iniciar `$this->items` como um array vazio (`[]`) e `$this->total` igual a `0`.
* **Comportamento dos Métodos:**
  * `addItem($item, $price)`: Adiciona o produto `$item` ao array associativo usando seu nome como chave e o preço como valor (`$this->items[$item] = $price`). Em seguida, incrementa o atributo `$total` com o valor adicionado.
  * `getTotal()`: Retorna o valor acumulado em `$total`.

---

## Exercício 5: Classe `Person` com o Método Mágico `__toString`

**Instruções para o Aluno:**
Crie uma classe chamada `Person` com as propriedades privadas `name` e `age`. Defina um construtor que inicializa essas variáveis. Em seguida, implemente o método mágico do PHP `__toString()` para retornar uma representação formatada em string com as informações do objeto quando ele for tratado ou exibido diretamente (por exemplo, ao usar o comando `echo $objeto`).

### Explicação do Modelo para Criação:
* **Atributos Privados:**
  * `private $name` (nome da pessoa).
  * `private $age` (idade da pessoa).
* **Método Construtor:**
  * O `__construct($name, $age)` deve aceitar o nome e a idade para preencher os respectivos atributos privados da instância.
* **Comportamento do Método Mágico `__toString()`:**
  * Este método especial do PHP deve retornar uma string contendo a formatação final dos dados da pessoa (ex: `"Nome: ... <br> Idade: ... <br>"`). Ele não imprime nada com `echo` internamente; apenas retorna (`return`) a string formatada.

---


## Exercício 6: Classe `ShoppingCart` com Desconto Especial

**Instruções para o Aluno:**
Evolua a classe `ShoppingCart` criada no **Exercício 4**. Implemente uma regra de negócio de fidelidade: caso o carrinho possua 3 ou mais itens adicionados, o sistema deve aplicar um desconto de 10% no valor total acumulado da compra. Crie um novo método chamado `calculateDiscount()` ou ajuste o método `getTotal()` para retornar o valor total já corrigido com o desconto se a condição for atingida.

### Explicação do Modelo para Criação:
* **Atributos Adicionais/Lógica:**
  * É necessário contar quantos itens existem dentro do array `$this->items`. Para fazer isso em PHP, utilizamos a função interna `count($this->items)`.
* **Comportamento dos Métodos:**
  * O método de desconto deve avaliar: se a quantidade de itens for igual ou superior a 3, calcula 10% do total acumulado (`$this->total * 0.10`) e subtrai do valor total que será retornado ao usuário.

---

## Exercício 7: Validação de Dados na Classe `Student` (Setters Seguros)

**Instruções para o Aluno:**
Voltando à estrutura da classe `Student` criada no **Exercício 1**, adicione validações de segurança nos métodos modificadores (setters). Você deve garantir que a idade (`setAge()`) não possa ser definida com um número negativo ou zero. Além disso, valide a nota/série (`setGrade()`) para que aceite apenas valores entre 1 e 12 (comum nos anos letivos escolares). Se os dados forem inválidos, exiba uma mensagem de erro apropriada e impeça a alteração do atributo.

### Explicação do Modelo para Criação:
* **Modificação de Métodos Setters Existentes:**
  * No método `setAge($age)`, crie uma estrutura condicional `if ($age <= 0)`. Se a condição for verdadeira, exiba um alerta e não altere o atributo. Caso contrário, atribua o valor com `$this->age = $age`.
  * No método `setGrade($grade)`, faça uma verificação semelhante: certifique-se de que a nota/série esteja entre 1 e 12 (`if ($grade >= 1 && $grade <= 12)`). Se o valor estiver fora desse intervalo, mostre uma mensagem de erro.

---

## Exercício 8: Validação de Ano na Classe `Vehicle` (Segurança nos Atributos)

**Instruções para o Aluno:**
Aprimore o encapsulamento da classe `Vehicle` do **Exercício 2**. Adicione uma regra de integridade de dados ao definir o ano do veículo. Crie um método setter específico para o ano (`setYear($year)`) que valide se o valor fornecido possui exatamente 4 dígitos e se é do tipo numérico. Adapte o método construtor para que ele utilize essa validação (o setter) em vez de atribuir o valor diretamente ao atributo interno.

### Explicação do Modelo para Criação:
* **Implementação da Lógica de Validação:**
  * Converta o ano para string temporariamente ou conte o número de dígitos numéricos. Uma boa abordagem em PHP é verificar se o ano é maior que 999 e menor ou igual ao ano atual, ou usar funções como `is_numeric($year)` combinada com a medição de comprimento `strlen((string)$year) == 4`.
  * Caso o ano seja inválido, uma mensagem de erro explicativa deve ser exibida e o valor padrão não deve ser alterado.

---

## Exercício 9: Comparação de Objetos na Classe `Person`

**Instruções para o Aluno:**
Implemente um método na sua classe `Person` (do **Exercício 5**) chamado `compareAge(Person $otherPerson)`. Esse método deve receber como parâmetro um outro objeto da mesma classe `Person` (fazendo uso do recurso de *Type Hinting* do PHP) e comparar as idades das duas instâncias. O método deve retornar uma string dizendo qual das duas pessoas é mais velha ou se elas possuem a mesma idade.

### Explicação do Modelo para Criação:
* **Uso de Getters de Idade:**
  * Para que o método funcione, você precisará criar um método getter público para a idade (`getAge()`) na classe `Person`, permitindo que uma instância leia a idade de outra instância de forma controlada.
* **Comportamento do Método `compareAge(Person $otherPerson)`:**
  * O método deve acessar `$this->age` (da pessoa atual) e comparar com o método do objeto passado por parâmetro: `$otherPerson->getAge()`.
  * Utilize uma estrutura `if / elseif / else` para avaliar se o objeto atual é mais velho, mais novo ou se tem a mesma idade que a outra pessoa recebida. Retorne o resultado como uma frase explicativa.
