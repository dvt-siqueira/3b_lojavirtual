# Aula 10: A Imagem do Sucesso (Upload de Arquivos com POO)

Nesta aula, daremos um passo fundamental para tornar nossa Loja Virtual visualmente atraente. Vamos aprender como o PHP manipula arquivos e, mais importante, como encapsular essa lógica dentro da nossa **Classe Produto**, seguindo os padrões da Programação Orientada a Objetos (POO).

---

# 🎯 Objetivos da Aula
* Entender como o PHP recebe arquivos através da superglobal `$_FILES`.
* Compreender por que o formulário HTML exige o atributo `enctype="multipart/form-data"`.
* Implementar a lógica de upload como um **Método** da classe `Produto`.
* Aplicar o conceito de **Encapsulamento** para validar o tipo de arquivo e organizar as pastas do servidor.
* Entender a separação correta entre **Model** (regras de negócio e estruturas de dados) e **Controller/Scripts de Ação** (`salvar.php`).

---

#### PARTE 1: O Conceito (Onde guardamos a foto?)

**Analogia do Porta-Retratos:**
Imagine que sua Classe Produto é um porta-retratos. O porta-retratos **não guarda a pessoa real** dentro dele, ele guarda apenas a **foto** (uma representação). No banco de dados, faremos o mesmo: não salvaremos o "arquivo binário da imagem" dentro da tabela, mas sim o **nome/caminho** de onde ela está guardada no servidor (ex: `a1f8b2c3...jpg`).

**Por que usar POO para Upload?**
No modelo procedural, teríamos funções soltas para validar a imagem. Na POO, o próprio Objeto Produto "sabe" como cuidar do processamento do seu arquivo. Isso evita duplicar código e garante que qualquer página do sistema que precise realizar upload de fotos de produtos utilize as mesmas regras de segurança.

---

#### PARTE 2: Preparando o "Molde" (Atributos e HTML)

Primeiro, precisamos atualizar nossa classe e nosso formulário.

**1. No formulário (`admin/produtos/cadastrar.php`):**
> ⚠️ **Dica de Ouro / Ponto de Atenção:** Para enviar arquivos (imagens, PDFs, etc.), a tag `<form>` **OBRIGATORIAMENTE** precisa do atributo `enctype="multipart/form-data"`. Sem isso, o navegador envia apenas os dados de texto e ignora completamente o arquivo selecionado no `<input type="file">`!

```html
<form action="salvar.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="nome">Nome do Produto</label>
        <input type="text" id="nome" name="nome" class="form-control" required placeholder="Ex: Teclado Mecânico">
    </div>

    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <label for="preco">Preço (R$)</label>
            <input type="number" id="preco" name="preco" class="form-control" step="0.01" required placeholder="0,00">
        </div>
        <div>
            <label for="quantidade">Quantidade em Estoque</label>
            <input type="number" id="quantidade" name="quantidade" class="form-control" required placeholder="0">
        </div>
        <div>
            <label>Foto do Produto:</label>
            <input type="file" name="foto" accept="image/*" required>
        </div>
    </div>

    <div class="form-group">
        <label for="descricao">Descrição do Produto</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" placeholder="Detalhes..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary" style="width: 100%;">
        <i class="fa-solid fa-save"></i> Salvar Produto
    </button>
</form>
```

**2. No arquivo `models/produtos.php`:**
A classe deve conter **apenas** as definições de atributos e métodos. 

> 🚫 **Boas Práticas de POO (Atenção):** Nunca coloque scripts de teste, `echo`, chamadas de funções de exibição (`exibirnavbar()`) ou instâncias soltas (`$p = new Produto()`) no escopo global do arquivo do Model. O Model deve ser um arquivo puro de classe, servindo como molde para o restante do sistema.

```php
<?php
require_once __DIR__ . '/../config.php';

class Produto
{
    public $id;
    public $nome;
    public $preco;
    public $quantidade;
    public $descricao;
    public $foto; // Atributo para armazenar o nome do arquivo da imagem
}
```

---

#### PARTE 3: A Inteligência (Criando o Método de Upload)

Vamos criar o método `fazerUpload()` dentro da classe `Produto`. Usaremos o conceito de **Encapsulamento** para garantir que o nome da imagem seja único (evitando sobrescrever fotos existentes) e que a pasta de destino receba a barra no final (`/`).

```php
// Dentro da classe Produto em models/produtos.php
public function fazerUpload($arquivo)
{
    // 1. Definimos o destino e geramos um nome único usando md5 e uniqid
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $novoNome = md5(uniqid()) . "." . $extensao;
    
    // Importante: a barra / no final garante que o arquivo vai para dentro do diretório
    $diretorio = "../../assets/img/produtos/";

    // 2. Validação básica de extensões permitidas
    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array(strtolower($extensao), $tiposPermitidos)) {
        return false; // Tipo de arquivo não permitido
    }

    // 3. Movemos o arquivo da pasta temporária do PHP para a pasta final do servidor
    if (move_uploaded_file($arquivo['tmp_name'], $diretorio . $novoNome)) {
        $this->foto = $novoNome; // Salva o nome gerado no atributo do objeto
        return true;
    }
    return false;
}
```

---

#### PARTE 4: Mão na Massa (Integrando com o Banco no `salvar.php`)

Agora, no arquivo responsável por receber o formulário e salvar no banco de dados, integramos o upload com a instrução `INSERT` do PDO. 

O arquivo `salvar.php` executa o upload **primeiro**; se a imagem for gravada na pasta com sucesso, executamos o comando SQL incluindo o parâmetro `:foto`.

```php
<html>
<head>
    <link rel="stylesheet" href="../../css/style.css">
    <title>Produto Salvo</title>
</head>
<body>
    <div class="container">
        <?php
        require_once "../../config.php";
        require_once "../../models/produtos.php";

        $mensagem = "";
        $p = new Produto();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recebe os dados do formulário
            $nome       = $_POST["nome"] ?? '';
            $preco      = $_POST["preco"] ?? 0;
            $descricao  = $_POST["descricao"] ?? '';
            $quantidade = $_POST["quantidade"] ?? 0;

            // 1. Tenta realizar o upload da imagem
            if (isset($_FILES['foto']) && $p->fazerUpload($_FILES['foto'])) {
                $foto = $p->foto; // Nome gerado pelo método fazerUpload()

                // 2. Prepara a query SQL com os Named Parameters
                $sql = "INSERT INTO produtos (nome, preco, descricao, quantidade, foto)
                        VALUES (:nome, :preco, :descricao, :quantidade, :foto)";
                
                $stmt = $pdo->prepare($sql);

                // 3. Executa a gravação no Banco de Dados
                try {
                    $stmt->execute([
                        ':nome'       => $nome,
                        ':preco'      => $preco,
                        ':descricao'  => $descricao,
                        ':quantidade' => $quantidade,
                        ':foto'       => $foto
                    ]);
                    $mensagem = "Produto '$nome' e foto salvos com sucesso!";
                } catch (PDOException $e) {
                    $mensagem = "Erro ao salvar no banco de dados: " . $e->getMessage();
                }
            } else {
                $mensagem = "Erro ao processar o upload da imagem. Verifique a extensão do arquivo.";
            }
        } else {
            $mensagem = "Requisição inválida.";
        }
        ?>

        <h1><?php echo $mensagem; ?></h1>
    </div>
</body>
</html>
```

---

#### PARTE 5: Exibindo a Imagem Profissionalmente

Para exibir a foto na vitrine ou na listagem de produtos, criamos um método auxiliar na classe para tratar os casos em que o produto não possui foto cadastrada.

```php
public function getUrlFoto()
{
    if ($this->foto) {
        return "../../assets/img/produtos/" . $this->foto;
    }
    return "../../assets/img/produtos/sem-foto.png"; // Imagem padrão
}
```

**Uso na tela de listagem (`listar.php`):**
```html
<img src="<?php echo $produto->getUrlFoto(); ?>" alt="Foto de <?php echo $produto->nome; ?>" width="100">
```

---

# 🧑‍💻 Desafios

#### 1. Validação de Tamanho (Proteção do Servidor)
Modifique o método `fazerUpload` para recusar arquivos maiores que 2MB (Dica: verifique a chave `$arquivo['size']` em bytes, onde 2MB = 2 * 1024 * 1024).

#### 2. Organização de Pastas
Crie a estrutura de pastas `assets/img/produtos/` na raiz do seu projeto `lojavirtual` e garanta que o servidor web possui permissão de escrita.

#### 3. Desafio Master: Substituição de Foto
Ao editar um produto existente, se o usuário enviar uma **nova foto**, a classe deve remover a **foto antiga** da pasta do servidor para evitar acúmulo de arquivos sem uso (Dica: utilize a função `unlink()` do PHP).

---

# 📌 Próxima Aula
**Login e Sessões:** Vamos aprender como restringir o acesso à área administrativa apenas para usuários autenticados, criando nossa classe de `Usuario`, manipulando a superglobal `$_SESSION` e protegendo nossas rotas.
