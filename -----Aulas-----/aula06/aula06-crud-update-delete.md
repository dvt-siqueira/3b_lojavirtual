# 📘 Programação para Internet III
## 📅 Aula 06 — Operações CRUD: Update (Edição) e Delete (Exclusão)

---

# 🎯 Objetivos da Aula

- Compreender as operações **Update (Atualização)** e **Delete (Exclusão)** do acrônimo **CRUD**.
- Aprender os comandos SQL `UPDATE` e `DELETE` com a cláusula `WHERE`.
- Criar a funcionalidade de exclusão de registros com confirmação de segurança.
- Desenvolver um formulário de edição que recupera dados existentes para alteração.
- Melhorar a interface visual do sistema administrativo utilizando a biblioteca de ícones **Font Awesome**.

---

# 🎨 Melhorando o Visual: Font Awesome

Para que nosso sistema administrativo tenha uma aparência profissional, vamos utilizar ícones para as ações de "Editar" e "Excluir". 

### 1. Adicionando a Biblioteca
No `<head>` do seu arquivo `listar.php`, adicione a seguinte linha:

```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
```

### 2. Exemplo de uso de Ícones
Substituiremos os links de texto por ícones estilizados:

```html
<!-- Ícone de Editar -->
<a href="editar.php?id=1" title="Editar">
    <i class="fa-solid fa-pen-to-square" style="color: #007bff;"></i>
</a>

<!-- Ícone de Excluir com Confirmação -->
<a href="excluir.php?id=1" onclick="return confirm('Tem certeza?')" title="Excluir">
    <i class="fa-solid fa-trash" style="color: #dc3545;"></i>
</a>
```

---

# 🗑️ Operação DELETE (Exclusão)

A exclusão é a operação mais simples, porém a mais perigosa. **Nunca** esqueça da cláusula `WHERE`, ou você apagará todos os registros do banco!

## 1. O Comando SQL
```sql
DELETE FROM produtos WHERE id = 1;
```

## 2. Criando o `excluir.php`
Este arquivo não possui HTML, ele apenas processa a exclusão e redireciona o usuário de volta para a lista.

```php
<?php
require_once "../../config.php";

// 1. Verificar se o ID foi passado via URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 2. Preparar e executar o comando de exclusão
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // 3. Redirecionar de volta para a listagem
        header("Location: listar.php?msg=sucesso_delete");
        exit;

    } catch (PDOException $e) {
        die("Erro ao excluir produto: " . $e->getMessage());
    }
} else {
    header("Location: listar.php");
    exit;
}
?>
```

---

# 📝 Operação UPDATE (Edição)

A edição é um processo de dois passos:
1.  **`editar.php`**: Um formulário que já vem preenchido com os dados atuais do produto.
2.  **`atualizar.php`**: O script que recebe os novos dados e salva no banco.

## 1. O Comando SQL
```sql
UPDATE produtos SET nome = 'Novo Nome', preco = 99.90 WHERE id = 1;
```

## 2. Criando o `editar.php`
O segredo aqui é usar o atributo `value="<?php echo $produto['nome']; ?>"` nos campos do formulário.

```php
<?php
require_once "../../config.php";

// Buscar os dados atuais do produto para preencher o formulário
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $p = $stmt->fetch();

    if (!$p) {
        die("Produto não encontrado!");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Produto</h1>
        <form action="atualizar.php" method="POST">
            <!-- Campo oculto para enviar o ID -->
            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">

            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo $p['nome']; ?>" required>

            <label>Preço:</label>
            <input type="number" step="0.01" name="preco" value="<?php echo $p['preco']; ?>" required>

            <label>Quantidade:</label>
            <input type="number" name="quantidade" value="<?php echo $p['quantidade']; ?>" required>

            <button type="submit">Salvar Alterações</button>
            <a href="listar.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
```

---

# 🛠️ Mão na Massa: Refatorando o `listar.php`

Vamos atualizar o arquivo `admin/produtos/listar.php` para incluir o **Font Awesome** e os novos botões de ação.

### Nova Estrutura da Tabela:
```php
<?php foreach ($produtos as $p): ?>
    <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo htmlspecialchars($p['nome']); ?></td>
        <td>R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
        <td><?php echo $p['quantidade']; ?></td>
        <td>
            <!-- Link para Editar -->
            <a href="editar.php?id=<?php echo $p['id']; ?>" title="Editar">
                <i class="fa-solid fa-pen-to-square"></i>
            </a> 
            
            <!-- Link para Excluir com Confirmação -->
            <a href="excluir.php?id=<?php echo $p['id']; ?>" 
               onclick="return confirm('Tem certeza que deseja excluir este produto?')" 
               title="Excluir" 
               style="color: red; margin-left: 10px;">
                <i class="fa-solid fa-trash"></i>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
```

---

# 🧑‍💻 Desafios

## Desafio 1: Mensagens de Feedback
No arquivo `listar.php`, verifique se existe o parâmetro `msg` na URL (ex: `listar.php?msg=sucesso_delete`). Se existir, exiba um alerta colorido (verde para sucesso) informando que a operação foi realizada.

## Desafio 2: Arquivo `atualizar.php`
Crie o arquivo `atualizar.php` seguindo a lógica do `salvar.php` (visto na Aula 04), mas utilizando o comando SQL `UPDATE` e recebendo o `id` via `POST`.

## Desafio 3: Tooltips e Estilo (CSS)
Utilize o CSS para que, ao passar o mouse sobre os ícones de ação, eles mudem de cor ou aumentem levemente de tamanho (efeito `hover`).

---

# 📌 Próxima Aula

- **Upload de Imagens:** Aprender como enviar fotos dos produtos para o servidor e salvar o caminho no banco de dados.
- **Validação de Formulários:** Garantir que os dados enviados pelo usuário sejam seguros e estejam no formato correto.
