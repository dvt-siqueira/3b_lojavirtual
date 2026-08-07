
# Aula: Integração POO e Sistema de Login (Mantendo o Padrão de Funções)

## 1. Banco de Dados
Criação da tabela para persistência dos dados do usuário.

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);
```

## 2. O Model: `models/Usuario.php`
Seguindo exatamente o padrão da classe `Produto`, onde importamos o `config.php` usando o caminho relativo `__DIR__ . '/../config.php'`.

```php
<?php
require_once __DIR__ . '/../config.php'; 

class Usuario {
    public $id;
    public $nome;
    public $email;
    public $senha;

    // Método para salvar no banco (Cadastro)
    public function cadastrar($nome, $email, $senha) {
        global $pdo;
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':n' => $nome, ':e' => $email, ':s' => $hash]);
    }

    // Método para autenticação (Login)
    public function login($email, $senha) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            // Se a senha estiver correta, salvamos os dados na sessão
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            return true;
        }
        return false;
    }
}
```

## 3. As Views (Telas) com `exibirNavbar()`
 **Importante:** Lembre-se de incluir o arquivo onde sua função `exibirNavbar()` está definida (ex: `functions.php`).

### Arquivo: `cadastro_usuario.php`
```php
<?php 
require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 Store - Cadastro de Usuário");

exibirNavbar(); 
?>

<div class="container mt-4">
    <h2>Criar Conta</h2>
    <form action="controllers/processar_cadastro.php" method="POST" class="frm-usuario">
        <input type="text" name="nome" placeholder="Nome" class="form-control mb-2" required>
        <input type="email" name="email" placeholder="E-mail" class="form-control mb-2" required>
        <input type="password" name="senha" placeholder="Senha" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
<?php
exibirRodape();
?>
```

### Arquivo: `login.php`
```php
<?php 
require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 Store - Login");

exibirNavbar(); 
?>

<div class="container mt-4">
    <h2>Login</h2>
    <?php if(isset($_GET['erro'])) echo "<p style='color:red'>Dados inválidos!</p>"; ?>
    
    <form action="controllers/processar_login.php" method="POST" class="frm-usuario">
        <input type="email" name="email" placeholder="E-mail" class="form-control mb-2" required>
        <input type="password" name="senha" placeholder="Senha" class="form-control mb-2" required>
        <button type="submit" class="btn btn-success">Entrar</button>
    </form>
</div>

<?php
exibirRodape();
?>
```
### Arquivo: `style.css`
```CSS
.frm-usuario {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;

    display: flex;
    flex-direction: column;
    gap: 15px; /* distância entre todos os elementos */
}
```



## 4. Os Controllers (Processamento)
Estes arquivos fazem o trabalho "invisível" de conectar a tela ao banco de dados.

### Arquivo: `controllers/processar_cadastro.php`
```php
<?php
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new Usuario();
    if ($u->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha'])) {
        header("Location: ../login.php?sucesso=1");
    }
}
```

### Arquivo: `controllers/processar_login.php`
```php
<?php
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new Usuario();
    if ($u->login($_POST['email'], $_POST['senha'])) {
        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?erro=1");
    }
}
```

---

### Observação importante para a aula:
Para que a `exibirNavbar()` mostre o nome do usuário logado, você deve orientar os alunos a atualizarem a função no arquivo de funções:

```php
function exibirNavbar() {
    // Agora verificamos a sessão dentro da função que eles já criaram
    if (isset($_SESSION['usuario_nome'])) {
        echo "<span>Olá, " . $_SESSION['usuario_nome'] . " | <a href='logout.php'>Sair</a></span>";
    } else {
        echo "<a href='login.php'>Login</a>";
    }
}
```

Dessa forma, respeitamos o aprendizado passo a passo sem introduzir novos conceitos de estrutura de pastas (como a pasta `views`) antes da hora.