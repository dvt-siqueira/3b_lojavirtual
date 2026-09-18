# Caderno de Exercícios Práticos: Herança e Polimorfismo em PHP

Este material foi elaborado para auxiliar na prática em sala de aula ou como lista de exercícios extraclasse para a turma. Ele contém exercícios simples e progressivos focados na fixação de **Herança** e **Polimorfismo** .

---

## Exercício 1: Herança Básica (Relação "É um")

**Objetivo:** Compreender como criar classes derivadas que herdam propriedades e comportamentos básicos da superclasse.

### Cenário
Imagine um sistema escolar. Tanto um funcionário quanto um aluno são "Pessoas", compartilhando nome e idade. No entanto, um aluno tem comportamentos específicos de estudo.

### O que fazer:
1. Crie uma classe base chamada `Pessoa` com propriedades protegidas `$nome` e `$idade`, além de um construtor e um método público `apresentar()`.
2. Crie uma classe-filha chamada `Aluno` que herda de `Pessoa` usando `extends`.
3. A classe `Aluno` deve conter uma nova propriedade protegida `$matricula` e um método `estudar()` que exibe uma mensagem indicando que o aluno está estudando.
4. Escreva um construtor na classe `Aluno` que recebe o `$nome`, `$idade` e `$matricula`. Utilize `parent::__construct()` para inicializar os atributos da classe-mãe .


### Saída Esperada
```text
Olá, meu nome é Lucas e tenho 17 anos.
Matrícula: 2026-009. Lucas está assistindo à aula e estudando PHP!
```

---

## Exercício 2: Visibilidade e Modificadores de Acesso (`private` vs `protected`)

**Objetivo:** Praticar o encapsulamento de dados e entender na prática a diferença entre propriedades acessíveis diretamente na herança (`protected`) e restritas à classe original (`private`).

### Cenário
Criaremos um sistema de contas bancárias simplificado.

### O que fazer:
1. Crie uma classe `Conta` com um atributo **protegido** `$numero` e um atributo **privado** `$saldo`.
2. Crie um construtor para inicializar ambos e os métodos públicos `depositar($valor)` e `getSaldo()` (lembre-se de usar `recuperaSaldo()` no nosso padrão nacional).
3. Crie uma subclasse `ContaPoupanca` que herda de `Conta`.
4. Crie um método público `renderJuros($taxa)` em `ContaPoupanca`.
5. **Atenção:** Tente acessar diretamente `$this->saldo` dentro de `ContaPoupanca` para ver o que acontece (deve dar erro). Corrija-o acessando o saldo através do método público herdado.


---

## Exercício 3: Polimorfismo Dinâmico (Sobrescrita de Métodos)

**Objetivo:** Implementar o conceito de "muitas formas" redefinindo métodos nas subclasses para comportamentos diferentes.

### Cenário
Vamos modelar diferentes animais de estimação que emitem sons variados.

### O que fazer:
1. Crie uma classe base `Animal` com um método público chamado `emitirSom()` que exibe `"Som genérico de animal"`.
2. Crie as subclasses `Cachorro` e `Gato` herdando de `Animal`.
3. Sobrescreva o método `emitirSom()` em `Cachorro` para exibir `"Au Au!"` e em `Gato` para exibir `"Miau!"`.
4. Crie uma função fora das classes chamada `fazerOAnimalCantar(Animal $animal)`.
5. Instancie um objeto de cada classe, coloque-os em um array e use um loop para demonstrar o polimorfismo dinâmico.

---

## Exercício 4: Polimorfismo com Interfaces (Assinatura de Contratos)

**Objetivo:** Compreender como padronizar comportamentos entre classes que podem não ter parentesco entre si através de uma interface comum.

### Cenário
Queremos criar uma ferramenta de visualização de conteúdo em telas. Diversos elementos do sistema precisam ser "exibidos na tela", mas cada um se renderiza de um jeito diferente.

### O que fazer:
1. Crie uma interface chamada `Renderizavel` com a assinatura do método `renderizar()`.
2. Crie a classe `Texto` (com propriedade `$conteudo`) que implementa a interface `Renderizavel` [54]. O método `renderizar()` deve exibir o texto formatado.
3. Crie a classe `Imagem` (com propriedade `$url`) que implementa `Renderizavel`. O método `renderizar()` deve simular o carregamento da imagem exibindo a URL em uma tag fictícia.
4. Crie uma função pública `carregarNaTela(Renderizavel $elemento)` que chama o método polimórfico `renderizar()`.
---