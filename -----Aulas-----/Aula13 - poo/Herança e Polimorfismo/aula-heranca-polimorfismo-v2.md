# Herança e Polimorfismo em Programação Orientada a Objetos com PHP (v2)

---

## 1. Introdução à Herança

### O que é Herança?
No mundo real, herança refere-se a receber algo de nossos antepassados . Na programação, a **Herança** é um mecanismo fundamental da POO que permite construir uma nova classe (chamada de **classe filha** ou **subclasse**) com base em uma classe preexistente (chamada de **classe pai**, **classe mãe** ou **superclasse**). 

A subclasse herda automaticamente todos os atributos, comportamentos (métodos) e implementações da superclasse, eliminando a necessidade de reescrever código já existente.

### Vantagens da Herança
*   **Reutilização de Código:** Evita a duplicação ou reescrita desnecessária de lógica comum.
*   **Melhoria na Organização:** Permite estruturar o sistema em hierarquias lógicas e fáceis de navegar.
*   **Extensibilidade:** Facilita a expansão do software com novas funcionalidades de forma rápida .

### Sintaxe e Exemplo de Herança em PHP
No PHP, a herança é estabelecida através da palavra-chave `extends`. Vale destacar que o PHP **não suporta herança múltipla** (uma classe filha só pode estender diretamente uma única classe pai) .

Abaixo está um exemplo conceitual simples utilizando uma classe `Animal` como pai e a classe `Cachorro` como filha:

```php
<?php

// Superclasse (Classe Pai)
class Animal {
    protected $nome; // Atributo protegido: acessível apenas na classe pai e filhas 

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function falar() {
        echo "O animal faz um som.\n";
    }
}

// Subclasse (Classe Filha) que herda de Animal
class Cachorro extends Animal {
    // Herdará automaticamente a propriedade $nome e o método falar() 
    
    // Sobrescrita do método falar() para dar um comportamento específico 
    public function falar() {
        echo "O cachorro {$this->nome} late: Au Au!\n";
    }
}

// Instanciação e Utilização
$cachorro = new Cachorro("Rex");
$cachorro->falar(); // Saída: O cachorro Rex late: Au Au!
```

### Modificadores de Acesso e Visibilidade
Para aplicar a herança corretamente, é essencial entender o papel dos modificadores de acesso:
1.  **`public`:** O atributo ou método é acessível de qualquer lugar .
2.  **`protected`:** O atributo ou método é protegido. Ele não pode ser acessado diretamente fora das classes, mas é visível e utilizável pela superclasse e por todas as suas subclasses.
3.  **`private`:** O atributo ou método é privado e pertence exclusivamente à classe que o declarou. Subclasses não conseguem acessá-lo ou modificá-lo diretamente, o que pode requerer métodos auxiliares (getters/setters).

---

## 2. Acessando a Superclasse com `parent` e `self`

Quando estamos trabalhando dentro de uma classe filha, podemos querer fazer referência a métodos ou membros da superclasse ou da própria classe. Para isso, utilizamos as seguintes palavras-chave :

*   **`self::`** Faz referência à própria classe atual (classe filha) .
*   **`parent::`** Faz referência direta à superclasse (classe pai), permitindo chamar construtores ou métodos originais que foram sobrescritos [4, 9].

### Exemplo Prático de Uso do `parent` e `self`
No exemplo a seguir, observe como podemos diferenciar e chamar os métodos usando os escopos de resolução :

```php
<?php

class Configura {
    protected $valor = 'Valor da superclasse';

    protected function ver() {
        return "Classe mãe: " . $this->valor . "\n";
    }
}

class Mostra extends Configura {
    protected $valor = 'Valor da subclasse';

    // Sobrescrita do método ver()
    protected function ver() {
        return "Classe filha: " . $this->valor . "\n";
    }

    public function testarEscopos() {
        // self::ver() chama o método ver() desta classe (Mostra) [9]
        echo self::ver(); 
        
        // parent::ver() chama o método ver() da classe pai (Configura) [4, 9]
        echo parent::ver(); 
    }
}

$objeto = new Mostra();
$objeto->testarEscopos();
/* 
Saída esperada:
Classe filha: Valor da subclasse
Classe mãe: Valor da subclasse (Atenção ao comportamento do $this!)
*/
```

### Explicação Prática: O Escopo do `$this` e a diferença de `protected` vs `private`

Muitos estudantes (e desenvolvedores experientes!) se surpreendem com o fato de `parent::ver()` exibir `"Classe mãe: Valor da subclasse"` em vez de `"Classe mãe: Valor da superclasse"`. Vamos entender o motivo disso e como controlar esse comportamento.

#### 1. Por que `$this->valor` exibe o valor da subclasse?
* **O que é o `$this`?** A pseudo-variável `$this` representa a **instância do objeto atual** que está em execução na memória. Nesse exemplo, o objeto criado na memória é do tipo `Mostra` (a subclasse).
* **Sobrescrita física:** Como a propriedade `$valor` é declarada como `protected` na classe-mãe (`Configura`) e redefinida na classe-filha (`Mostra`), o PHP realiza a sobrescrita (override) dessa propriedade na instância . Ou seja, passa a existir apenas **um único espaço em memória** para a propriedade `$valor` do objeto `$objeto`, e o valor armazenado lá é o da subclasse (`'Valor da subclasse'`) [8].
* **Executando o método pai:** Mesmo que `parent::ver()` chame fisicamente o código escrito na classe `Configura`, a chamada está rodando no contexto do nosso objeto `$objeto` [13]. Portanto, a linha `return "Classe mãe: " . $this->valor` acessa a única propriedade `$valor` que existe nesse objeto, que possui o valor sobrescrito.

#### 2. Como fazer a classe-mãe manter seu próprio valor? (Solução com `private`)
Se você quer que o método `ver()` da superclasse utilize estritamente o valor de origem definido nela, impedindo que a subclasse o substitua nesse contexto, você deve alterar a visibilidade do atributo para **`private`**:

```php
<?php

// Superclasse com atributo private
class Configura {
    private $valor = 'Valor da superclasse'; // Agora é private!

    protected function ver() {
        return "Classe mãe: " . $this->valor . "\n";
    }
}

// Subclasse
class Mostra extends Configura {
    // Como a propriedade da mãe é private, esta propriedade pública ou protegida
    // na filha passa a coexistir de forma independente na memória.
    public $valor = 'Valor da subclasse';

    protected function ver() {
        return "Classe filha: " . $this->valor . "\n";
    }

    public function testarEscopos() {
        echo self::ver(); 
        echo parent::ver(); 
    }
}

$objeto = new Mostra();
$objeto->testarEscopos();
/* 
Nova Saída esperada:
Classe filha: Valor da subclasse
Classe mãe: Valor da superclasse
*/
```

* **Por que funciona?** Atributos declarados como `private` são exclusivos da classe que os criou e não são compartilhados com as filhas. Internamente, o PHP separa as propriedades privadas da classe-mãe das propriedades da classe-filha. Desse modo, o método `ver()` da superclasse consegue acessar a variável privada original, isolando as redefinições feitas na subclasse.

---

## 3. Introdução ao Polimorfismo

### O que é Polimorfismo?
Do grego \"muitas formas\", o **Polimorfismo** permite que objetos de diferentes classes sejam tratados como se fossem de uma mesma classe ou interface base, porém cada um executando comportamentos específicos de acordo com a sua própria estrutura.

No PHP, existem duas formas principais de alcançar o polimorfismo:
1.  **Polimorfismo Dinâmico (Sobrescrita de Métodos):** Ocorre quando uma classe filha redefine (sobrescreve) um método que já existe na classe pai. Em tempo de execução, o PHP identifica qual é o tipo real do objeto e executa a versão correspondente do método.
2.  **Polimorfismo com Interfaces:** Várias classes sem uma relação direta de parentesco implementam a mesma interface. O sistema interage com as classes através da interface, garantindo flexibilidade total para adicionar novas classes no futuro.

*(Nota teórica: O PHP não suporta diretamente a **sobrecarga de métodos** de forma estática como outras linguagens, mas permite simular isso através de métodos mágicos como `__call()`).*

---

## 4. Implementação Prática de Polimorfismo

Para mostrar a força do polimorfismo, apresentamos dois cenários que são comuns em sistemas comerciais.

### Cenário A: Polimorfismo com Herança (Sobrescrita)
Imaginemos um sistema de RH corporativo. Todos os funcionários têm um nome e um comportamento básico de trabalho, mas o gerente e o desenvolvedor trabalham de formas completamente diferentes.

```php
<?php

class Funcionario {
    protected $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function trabalhar() {
        echo "{$this->nome} está executando suas tarefas básicas.\n";
    }
}

class Gerente extends Funcionario {
    // Sobrescrita do método trabalhar 
    public function trabalhar() {
        echo "{$this->nome} está gerenciando a equipe e planejando projetos.\n";
    }
}

class Desenvolvedor extends Funcionario {
    // Sobrescrita do método trabalhar 
    public function trabalhar() {
        echo "{$this->nome} está escrevendo linhas de código em PHP.\n";
    }
}

// Uma função genérica que lida com QUALQUER funcionário
// Graças ao polimorfismo, ela não precisa saber o cargo exato antes de chamar trabalhar() [80]
function iniciarExpediente(Funcionario $funcionario) {
    $funcionario->trabalhar();
}

// Criação de uma lista de funcionários variados
$equipe = [
    new Gerente("Carlos"),
    new Desenvolvedor("Ana"),
    new Funcionario("Marcos")
];

// Executando o expediente polimorficamente 
foreach ($equipe as $membro) {
    iniciarExpediente($membro);
}

/*
Saída:
Carlos está gerenciando a equipe e planejando projetos.
Ana está escrevendo linhas de código em PHP.
Marcos está executando suas tarefas básicas.
*/
```

### Cenário B: Polimorfismo com Interfaces (Contrato Comum)
Uma **Interface** define as regras de quais métodos um objeto deve expor, mas não dita como eles devem funcionar por dentro. Isso é perfeito para integrarmos diferentes soluções externas, como **Sistemas de Pagamento**.

```php
<?php

// Definindo a interface (contrato comum) 
interface MetodoPagamento {
    public function pagar(float $valor);
}

// Classes que implementam a interface
class CartaoCredito implements MetodoPagamento {
    public function pagar(float $valor) {
        echo "Pagamento de R$ {$valor} feito com Cartão de Crédito.\n";
    }
}

class PayPal implements MetodoPagamento {
    public function pagar(float $valor) {
        echo "Pagamento de R$ {$valor} feito com PayPal.\n";
    }
}

class TransferenciaBancaria implements MetodoPagamento {
    public function pagar(float $valor) {
        echo "Pagamento de R$ {$valor} feito via Transferência Bancária.\n";
    }
}

// Função de processamento de pagamento genérica.
// Ela aceita qualquer classe que assine o contrato "MetodoPagamento"
function processarVenda(MetodoPagamento $metodo, float $total) {
    $metodo->pagar($total);
}

// Execução dinâmica
$compra1 = new PayPal();
$compra2 = new CartaoCredito();

processarVenda($compra1, 150.00); // Saída: Pagamento de R$ 150 feito com PayPal.
processarVenda($compra2, 85.50);  // Saída: Pagamento de R$ 85.5 feito com Cartão de Crédito.
```

Com este design, se você decidir adicionar uma nova forma de pagamento (como Pix), basta criar a classe correspondente implementando a interface `MetodoPagamento` sem precisar alterar uma única linha de código da função `processarVenda` [57, 58]. Isso torna a aplicação altamente sustentável e extensível [60].

---

## Desafio

**Tema:** Controle de Frota de Veículos de Entrega

1.  **Crie uma superclasse** chamada `Veiculo` com os atributos protegidos `$placa` e `$capacidadeCarga`, um método construtor e um método público `realizarEntrega($distancia)`.
2.  **Crie duas subclasses** que herdam de `Veiculo` :
    *   `Caminhao` (deve ter um atributo extra `$numeroEixos` e sobrescrever o método `realizarEntrega` para adicionar uma mensagem sobre desgaste de pneus proporcional aos eixos) .
    *   `Moto` (deve sobrescrever `realizarEntrega` para destacar a agilidade no trânsito rápido) .
3.  **Crie um script** que instancia um Caminhão e uma Moto, armazena-os em um array e, usando um loop `foreach`, simula entregas de 50km de forma polimórfica.

---

## Resumo dos Conceitos 

*   **Herança (`extends`):** Relação do tipo \"é um\" (ex: Gerente *é um* Funcionário). Foco principal na **reutilização e estruturação**.
*   **Polimorfismo:** Relação focada na **intercambiabilidade de comportamentos** . Foco em padronizar as ações por meio de assinaturas de métodos comuns (seja por herança de métodos da superclasse ou por assinatura de contratos via interfaces).
*   **Interface (`interface` e `implements`):** Não possui código de implementação, serve puramente como um contrato abstrato para garantir assinaturas consistentes de comportamento.
