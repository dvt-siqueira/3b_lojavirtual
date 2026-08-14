
# Aula 12: A Memória do Sistema (Sessões vs. Cookies)

Nesta aula, aprenderemos como fazer com que nossa Loja Virtual "se lembre" de quem é o usuário. Até agora, cada clique era como se o servidor visse o cliente pela primeira vez. Hoje, vamos criar uma identidade persistente para o usuário usando **Sessões** (para segurança) e **Cookies** (para conveniência).

# 🎯 Objetivos da Aula
*   Entender a diferença fundamental entre Sessão (servidor) e Cookie (navegador).
*   Implementar o controle de acesso à área administrativa com `$_SESSION`.
*   Aprender a criar "lembranças" duradouras com `setcookie()`.
*   Integrar esses conceitos à nossa estrutura de componentes e classes.

---

#### PARTE 1: O Conceito (O crachá e o cartão de fidelidade)

**A Analogia do Evento VIP:**
1.  **A Sessão é o Crachá VIP:** Quando você entra na festa (faz login), a organização te dá um crachá. Enquanto você estiver lá dentro, todos sabem quem você é. Mas, se você for embora e jogar o crachá fora (fechar o navegador), na próxima vez precisará se identificar de novo na portaria.
2.  **O Cookie é o Cartão de Fidelidade:** Ele fica na **sua carteira** (seu navegador). Mesmo que você fique meses sem voltar à loja, quando retornar e mostrar o cartão, o sistema saberá suas preferências (como o tema escuro ou seu nome de usuário) sem que você precise dizer nada.

---

#### PARTE 2: Trabalhando com Sessões (Segurança no Servidor)

A Sessão é o local mais seguro para guardar o ID do usuário logado, pois os dados ficam no servidor.

**1. A regra de ouro:** Todo arquivo que for usar sessões **deve** começar com `session_start();` antes de qualquer HTML ou espaço em branco.

**2. Criando a Sessão (Ex: no `functions.php`):** (essa pagina é carregada em todo o sistema)
```php
<?php
session_start();
```
**3. Criando a Sessão (Ex: no `usuario.php `):**
```php
if ($user && password_verify($senha, $user['senha'])) {
            //adicionar o inicio da seção aqui
            session_start();
            // Se a senha estiver correta, salvamos os dados na sessão
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            return true;
        }
```

**3. Protegendo a Área Administrativa:**
No topo do seu `listar.php`, verificamos se o "crachá" existe:
```php
<?php
if (!isset($_SESSION['usuario_id'])) {
    // Se não tem crachá, volta para o login
    header("Location: ../../login.php?erro=restrito");
    exit;
}
```
**4. Criando o Logout:**
Criar arquivo  `logout.php`, para destruir a sessão criada no login:
```php
<?php
session_start(); // Inicia para poder identificar qual sessão fechar
session_destroy(); // Destrói todos os dados da sessão
header("Location: index.php"); // Redireciona para a home
exit;
```

**5. Personalizando os Menus:**
Editar o arquivo  `functions.php`, para filtrar os botões na index do projeto:
em exibirNavBar() edite o <ul>
```php

                <ul>

                    <?php 
                      //exibir itens diferentes no menu dependendo se o usuário está logado ou não
                    if (isset($_SESSION['usuario_id'])): ?>
                        <!-- Itens visíveis apenas para quem está logado -->
                        <li><a href="<?php echo $basePath; ?>logout.php">Logout</a></li>
                        <li><a href="<?php echo $basePath; ?>admin/produtos/listar.php" class="btn-admin">Admin</a></li>
                    <?php else: ?>
                        <!-- Item visível apenas para visitantes -->
                        <li><a href="<?php echo $basePath; ?>login.php">Login</a></li>
                    <?php endif; ?>

                </ul>
```
---

#### PARTE 3: Trabalhando com Cookies (Persistência no Navegador)

Vimos que a **Sessão** é como um crachá: você sai da festa e o devolve na portaria [conversation]. Agora, vamos conhecer os **Cookies**. Eles são como aquele **Cartão de Fidelidade** que você guarda na sua própria carteira (o navegador). Mesmo que você feche o site e desligue o computador, quando voltar, o cartão ainda estará lá para dizer ao sistema quem é você ou quais são suas preferências [conversation].


---

**1: O Conceito (A memória que mora no cliente)**

Diferente da Sessão, que vive no servidor, o Cookie é um pequeno arquivo de texto que o servidor pede para o navegador guardar. 
*   **Sessão:** Dados sensíveis (senhas, IDs, permissões de Admin).
*   **Cookies:** Preferências visuais, rastreio de itens vistos ou o famoso "lembrar meu e-mail".

---

**2: A Prática — Criando o "Destaque de Produto"**

Vamos criar uma funcionalidade onde, ao clicar no botão "Comprar", o PHP salva um cookie com o ID do último produto de interesse. Se esse cookie existir, o card do produto terá uma **borda azul**.

**1. Criando o link de interesse no Card:**
No seu componente `exibirCardProduto($p)` dentro do `functions.php`:

```php
function exibirCardProduto($p) {
    // Verificamos se este produto é o que está salvo no "cartão de fidelidade" (Cookie)
    $estiloDestaque = "";
    if (isset($_COOKIE['ultimo_interesse']) && $_COOKIE['ultimo_interesse'] == $p['id']) {
        $estiloDestaque = "border: 3px solid #2563eb; transform: scale(1.02);"; 
    }
    ?>
    <div class="product-card" style="<?php echo $estiloDestaque; ?>">
        <div class="product-image"><i class="fa-solid fa-box"></i></div>
        <div class="product-info">
            <h3><?php echo htmlspecialchars($p['nome']); ?></h3>
            <p class="price">R$ <?php echo number_format($p['preco'], 2, ",", "."); ?></p>
        </div>
        <!-- Link que aciona a gravação do Cookie -->
        <a href="salvar_interesse.php?id=<?php echo $p['id']; ?>" class="btn-buy">Comprar</a>
    </div>
    <?php
}
```

**2. O Script que grava a "lembrança": `salvar_interesse.php`**
Este arquivo não tem HTML, ele apenas anota o interesse e volta para a home.

```php
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // setcookie(nome, valor, expiração, caminho)
    // 86400 segundos = 1 dia. time() + 86400 = expira em 24h.
    setcookie("ultimo_interesse", $id, time() + 86400, "/");
}

header("Location: index.php");
exit;
```

---


