Com certeza! Com base no padrão das suas aulas anteriores (como a Aula 09 e as de CRUD) e utilizando os conceitos de Orientação a Objetos das aulas da professora Lara, estruturei uma nova aula focada em **Upload de Arquivos**.

Esta aula mantém o tom pedagógico, o uso de analogias e a estrutura profissional (MVC) que você utiliza.

---

# Aula 10: A Imagem do Sucesso (Upload de Arquivos com POO)

Nesta aula, daremos um passo fundamental para tornar nossa Loja Virtual visualmente atraente. Vamos aprender como o PHP manipula arquivos e, mais importante, como encapsular essa lógica dentro da nossa **Classe Produto**, seguindo os padrões da Programação Orientada a Objetos (POO).

# 🎯 Objetivos da Aula
*   Entender como o PHP recebe arquivos através da superglobal `$_FILES`.
*   Implementar a lógica de upload como um **Método** da classe Produto.
*   Aplicar o conceito de **Encapsulamento** para validar o tipo e tamanho das fotos.
*   Organizar as pastas do servidor para armazenar as imagens de forma profissional.

---

#### PARTE 1: O Conceito (Onde guardamos a foto?)

**Analogia do Porta-Retratos:**
Imagine que sua Classe Produto é um porta-retratos. O porta-retratos **não guarda a pessoa real** dentro dele, ele guarda apenas a **foto** (uma representação). No banco de dados, faremos o mesmo: não salvaremos o "arquivo da imagem" dentro da tabela, mas sim o **caminho/nome** de onde ela está guardada no servidor.

**Por que usar POO para Upload?**
No modelo procedural, teríamos funções soltas para validar a imagem. Na POO, o próprio Objeto Produto "sabe" como cuidar da sua própria foto. Isso evita que fotos de produtos sejam salvas em pastas erradas ou com nomes duplicados.

---

#### PARTE 2: Preparando o "Molde" (Atributos e HTML)

Primeiro, precisamos atualizar nossa classe e nosso formulário.

**1. No arquivo `models/Produto.php`:**
Adicionamos o atributo para a foto.
```php
class Produto {
    public $id;
    public $nome;
    public $preco;
    public $foto; // Novo atributo para o caminho da imagem
}
```

**2. No formulário (`admin/produtos/cadastrar.php`):**
**Dica de Ouro:** Para enviar arquivos, o seu `<form>` PRECISA do atributo `enctype="multipart/form-data"`. Sem isso, o PHP nunca receberá a foto!.

```html
<form action="salvar.php" method="POST" enctype="multipart/form-data">
    <label>Nome do Produto:</label>
    <input type="text" name="nome" required>
    
    <label>Foto do Produto:</label>
    <input type="file" name="foto" accept="image/*" required>
    
    <button type="submit">Salvar Produto</button>
</form>
```

---

#### PARTE 3: A Inteligência (Criando o Método de Upload)

Vamos criar um método dentro da classe `Produto` para gerenciar o arquivo recebido. Usaremos o conceito de **Encapsulamento** para proteger nosso sistema de arquivos maliciosos.

```php
// Dentro da classe Produto em models/Produto.php
public function fazerUpload($arquivo) {
    // 1. Definimos o destino e geramos um nome único para evitar sobrescrever fotos
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $novoNome = md5(uniqid()) . "." . $extensao;
    $diretorio = "../../assets/img/produtos/";

    // 2. Validação básica (Encapsulamento de Regras)
    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array(strtolower($extensao), $tiposPermitidos)) {
        return false; // Tipo de arquivo não permitido
    }

    // 3. Movemos o arquivo da pasta temporária para a pasta final
    if (move_uploaded_file($arquivo['tmp_name'], $diretorio . $novoNome)) {
        $this->foto = $novoNome; // Salva o nome no atributo do objeto
        return true;
    }
    return false;
}
```

---

#### PARTE 4: Mão na Massa (Integrando no Salvar)

Agora, veja como o seu arquivo `salvar.php` fica elegante e organizado usando o objeto.

```php
require_once "../../models/Produto.php";
require_once "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p = new Produto();
    $p->nome = $_POST['nome'];
    $p->preco = $_POST['preco'];

    // Chamamos a "inteligência" do objeto para cuidar da foto
    if (isset($_FILES['foto']) && $p->fazerUpload($_FILES['foto'])) {
        // Agora o $p->foto já contém o nome da imagem salva!
        // Aqui entraria o código SQL para dar o INSERT incluindo a foto
        echo "Produto e foto salvos com sucesso!";
    } else {
        echo "Erro ao processar a imagem.";
    }
}
```

---

#### PARTE 5: Exibindo a Imagem Profissionalmente

Para exibir a foto na vitrine ou na listagem, criamos um método para gerar o caminho completo.

```php
public function getUrlFoto() {
    if ($this->foto) {
        return "assets/img/produtos/" . $this->foto;
    }
    return "assets/img/produtos/sem-foto.png"; // Imagem padrão caso não tenha foto
}
```

**Uso na tela:**
`<img src="<?php echo $produto->getUrlFoto(); ?>" alt="Foto de <?php echo $produto->nome; ?>">`

---

# 🧑‍💻 Desafios

#### 1. Validação de Tamanho (Proteção)
Modifique o método `fazerUpload` para que ele recuse arquivos maiores que 2MB (Dica: use `$arquivo['size']`).

#### 2. Organização de Pastas
Crie a estrutura de pastas `assets/img/produtos/` dentro do seu projeto `lojavirtual` e certifique-se de que o servidor tem permissão para escrever nela.

#### 3. Desafio Master: Substituição
Ao editar um produto, se o usuário enviar uma **nova foto**, o objeto deve ser capaz de deletar a **foto antiga** da pasta para não entulhar o servidor (Dica: use a função `unlink()` do PHP).

---

# 📌 Próxima Aula
**Login e Sessões:** Vamos aprender como restringir o acesso à área administrativa apenas para usuários autorizados, criando nossa classe de `Usuario` e protegendo nossas rotas.