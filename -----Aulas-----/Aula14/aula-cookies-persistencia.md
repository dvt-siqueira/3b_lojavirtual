# Aula Prática: Cookies, Sessões e Persistência Local com PHP Orientado a Objetos (POO)

Esta aula foi desenhada para ensinar como o navegador e o servidor interagem para persistir informações do usuário, aplicando conceitos avançados de **Programação Orientada a Objetos (POO)** e **Encapsulamento** em PHP.

---

## 1. Conceito: Armazenamento e Persistência no Navegador

Na web tradicional, o protocolo HTTP é *stateless* (sem estado). Isso significa que cada requisição feita ao servidor é independente e não guarda lembrança das requisições anteriores. Para resolver isso e criar experiências contínuas (como manter um usuário logado ou salvar itens em um carrinho de compras), utilizamos mecanismos de persistência:

*   **Cookies:** Pequenos arquivos de texto salvos diretamente no navegador do usuário. Eles são enviados de volta ao servidor em todas as requisições HTTP subsequentes, o que permite ao servidor reconhecer o cliente. Possuem limitação de tamanho (cerca de 4KB) e data de expiração definida.
*   **Sessões (Sessions):** Os dados são armazenados de forma segura no **servidor**. O navegador do usuário armazena apenas um identificador único de sessão (chamado de `PHPSESSID`), geralmente salvo em um cookie temporário. Ao receber esse ID, o PHP recupera os dados salvos no servidor correspondentes àquele usuário.
*   **LocalStorage / SessionStorage:** Mecanismos modernos de armazenamento local do lado do cliente (HTML5), manipulados via JavaScript, que não são enviados automaticamente ao servidor em cada requisição.

### Por que encapsular a Persistência com POO?

Trabalhar diretamente com as variáveis globais do PHP (`$_COOKIE`, `$_SESSION`) em várias partes de um sistema gera códigos difíceis de manter e propensos a falhas de segurança. Ao encapsularmos essas operações dentro de **classes**, garantimos:

1.  **Segurança e Higienização de Dados:** Centralizamos a validação das chaves e valores inseridos ou lidos antes de gravá-los no navegador.
2.  **Facilidade de Manutenção (Desacoplamento):** Se amanhã decidirmos parar de usar cookies nativos e passarmos a salvar os dados em um Banco de Dados ou em outro sistema de cache (como Redis), alteramos apenas o código interno da nossa classe de armazenamento. O restante do sistema que chama os métodos continuará funcionando perfeitamente sem modificação nenhuma!

---

## Exercício 1 (Exemplo Resolvido): Classe `CookieManager`

**Objetivo:** Demonstrar como encapsular a criação, leitura e exclusão de cookies do navegador utilizando uma classe PHP com atributos privados e métodos públicos.

### Código de Exemplo

```php
<?php

class CookieManager {
    // Atributos privados para garantir o encapsulamento das configurações dos cookies
    private $defaultExpiry;
    private $path;

    /**
     * Construtor da classe
     * @param int $defaultExpiry Tempo padrão em segundos para expiração do cookie (padrão 1 hora)
     * @param string $path Caminho de validade do cookie no servidor
     */
    public function __construct($defaultExpiry = 3600, $path = "/") {
        $this->defaultExpiry = $defaultExpiry;
        $this->path = $path;
    }

    /**
     * Define um cookie no navegador de forma segura
     * @param string $name Nome do cookie
     * @param string $value Valor do cookie
     * @param int|null $expiry Tempo de expiração específico (opcional)
     * @return bool Retorna true se o cookie foi configurado com sucesso
     */
    public function set($name, $value, $expiry = null) {
        $expireTime = time() + ($expiry !== null ? $expiry : $this->defaultExpiry);
        // setcookie é uma função nativa do PHP que envia o cabeçalho HTTP de criação do cookie
        return setcookie($name, $value, $expireTime, $this->path, "", false, true); // O último parâmetro 'true' ativa o httponly para maior segurança
    }

    /**
     * Obtém o valor de um cookie ativo
     * @param string $name Nome do cookie
     * @param mixed $default Valor retornado caso o cookie não exista
     * @return mixed
     */
    public function get($name, $default = null) {
        if ($this->exists($name)) {
            return $_COOKIE[$name];
        }
        return $default;
    }

    /**
     * Verifica se um determinado cookie está definido no navegador
     * @param string $name Nome do cookie
     * @return bool
     */
    public function exists($name) {
        return isset($_COOKIE[$name]);
    }

    /**
     * Exclui um cookie do navegador do usuário
     * @param string $name Nome do cookie
     * @return bool
     */
    public function delete($name) {
        if ($this->exists($name)) {
            // Para deletar um cookie, define-se um tempo de expiração no passado (ex: time() - 3600)
            unset($_COOKIE[$name]);
            return setcookie($name, "", time() - 3600, $this->path);
        }
        return false;
    }
}

// --- EXEMPLO DE USO ---

// 1. Instanciando o gerenciador de cookies com expiração padrão de 5 minutos (300 segundos)
$cookieJar = new CookieManager(300);

// 2. Definindo uma preferência de tema para o usuário
$cookieJar->set("user_theme", "dark");

// 3. Recuperando e exibindo a preferência do usuário
if ($cookieJar->exists("user_theme")) {
    echo "Tema preferido: " . $cookieJar->get("user_theme") . "<br>";
} else {
    echo "Nenhum tema definido.<br>";
}

// 4. Deletando o cookie
$cookieJar->delete("user_theme");
?>
```

### Explicação do Modelo (Guia para o Aluno)

*   **Atributos Privados:** 
    *   `$defaultExpiry`: Armazena um valor inteiro representando o tempo padrão de expiração do cookie. Como é privado, o código externo não pode alterá-lo diretamente, protegendo a integridade da configuração.
    *   `$path`: String que define a pasta do servidor onde o cookie é válido. Por padrão, definimos `/` para indicar que é válido em todo o site.
*   **Método Construtor (`__construct`):**
    *   Permite definir as configurações globais de tempo e escopo dos cookies criados por essa instância no momento em que ela é criada (`new CookieManager(...)`), definindo valores iniciais padrão para evitar configurações repetitivas.
*   **Comportamento dos Métodos:**
    *   `set($name, $value, $expiry)`: Executa a gravação física no navegador calculando a hora exata da expiração baseado no horário atual do servidor (`time()`). Usa proteção extra contra ataques XSS ao ativar a diretiva *HttpOnly* (parâmetro `true` na função `setcookie`).
    *   `get($name, $default)`: Protege o sistema contra erros do tipo *Notice* (tentar ler chaves inexistentes no array global `$_COOKIE`). Se a chave não existir, retorna o valor padrão fornecido pelo desenvolvedor.
    *   `exists($name)`: Encapsula a verificação usando a função interna `isset` sobre o array de cookies nativos.
    *   `delete($name)`: Segue a especificação da web de que para remover um cookie, deve-se forçar sua data de expiração para o passado, limpando também a variável em memória com `unset`.

---
