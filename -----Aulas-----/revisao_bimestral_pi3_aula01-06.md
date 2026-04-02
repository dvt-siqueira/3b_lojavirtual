# Roteiro de Revisão - Prova Bimestral (Aulas 01 a 06)
**Disciplina:** Programação para Internet III (PHP & MySQL)

Este roteiro contém exercícios práticos para reforçar os conceitos que serão cobrados na prova. **Responda cada questão para massificar o conhecimento.**

---

### **Módulo 1: Fundamentos e Formulários (Aulas 01 e 02)**

1. **Diferença de Métodos:** Explique em quais situações é melhor utilizar o método `POST` em vez do método `GET` em um formulário HTML.
   *Resposta:* _________________________________________________________________________

2. **Captura de Dados:** Escreva o código PHP necessário para receber um campo chamado `usuario_nome` enviado por um formulário via `POST` e exibi-lo com a mensagem "Bem-vindo, [nome]!".
   *Código:* ___________________________________________________________________________

3. **Operadores:** Qual a diferença entre o operador `=` (atribuição) e o operador `==` (comparação)? Dê um exemplo de uso para cada um.
   *Resposta:* _________________________________________________________________________

---

### **Módulo 2: Estruturas de Controle e Arrays (Aula 03)**

4. **Laço While:** Crie um pequeno script PHP que utilize um laço `while` para imprimir os números de 10 até 1 (em ordem decrescente).
   *Código:* 
   ```php
   <?php
       
   ?>
   ```

5. **Arrays Associativos:** Dado o array `$aluno = ["nome" => "João", "nota" => 8.5];`, como você faria para exibir apenas a nota do aluno no navegador?
   *Código:* ___________________________________________________________________________

---

### **Módulo 3: Banco de Dados e SQL (Aula 04)**

6. **Inserção de Dados:** Escreva o comando SQL para inserir um novo produto na tabela `produtos`. O produto chama-se "Teclado Mecânico", custa "250.00" e tem "10" unidades em estoque.
   *SQL:* ______________________________________________________________________________

7. **Configuração PDO:** No arquivo `config.php`, o que acontece se o nome do banco de dados (`dbname`) estiver escrito incorretamente? Como o PHP geralmente reage a esse erro?
   *Resposta:* _________________________________________________________________________

---

### **Módulo 4: Listagem e Segurança (Aula 05)**

8. **Exibição Condicional:** Como você faria, dentro de um `foreach` de produtos, para que produtos com estoque zero (0) apareçam com o texto "Indisponível" em vez do número?
   *Lógica:* ___________________________________________________________________________

9. **Segurança XSS:** Por que é uma "boa prática" utilizar a função `htmlspecialchars()` ao exibir dados que vieram do banco de dados ou de formulários?
   *Resposta:* _________________________________________________________________________

---

### **Módulo 5: Update, Delete e Parâmetros (Aula 06)**

10. **Parâmetros via URL:** Em uma listagem, o link para excluir um produto geralmente é algo como `excluir.php?id=5`. No arquivo `excluir.php`, qual variável global do PHP você usa para capturar esse "5"?
    *Resposta:* ________________________________________________________________________

11. **Lógica de Deleção:** Imagine que você esqueceu de colocar a cláusula `WHERE` em um comando `DELETE FROM usuarios`. O que aconteceria com o seu banco de dados?
    *Resposta:* ________________________________________________________________________

12. **Redirecionamento:** Qual a importância de usar o comando `exit;` ou `die();` logo após uma função `header("Location: ...")`?
    *Resposta:* ________________________________________________________________________

---

### **Módulo Bônus: Desafio Prático de SQL**

13. Escreva um comando SQL que selecione todos os produtos da tabela `produtos` onde o preço seja maior que 100 e o estoque seja menor que 5, ordenando pelo nome de A-Z.
    *SQL:* _____________________________________________________________________________
