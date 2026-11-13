# 🌐 Aula Prática: Consumo de APIs REST e Manipulação de Datas em PHP

Nesta aula, expandiremos nossa aplicação e-commerce adicionando a funcionalidade de **Cadastro de Endereço de Entrega do Usuário**. 

Aprenderemos na prática dois conceitos fundamentais para qualquer desenvolvedor PHP:
1. **Consumo de APIs REST no Back-end** utilizando funções nativas do PHP.
2. **Manipulação de Datas e Horários** com as classes `DateTime` e `DateInterval`.

---

## 🗄️ Passo 1: Preparando o Banco de Dados

Antes de codificar, precisamos criar a tabela `enderecos` para armazenar as informações dos usuários.

Execute a query SQL abaixo no seu MySQL / phpMyAdmin:

```sql
CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `logradouro` varchar(150) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` char(2) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 🔌 Passo 2: Consumindo a API REST no PHP

Para buscar as informações de rua, bairro, cidade e estado a partir do CEP inserido pelo usuário, faremos uma requisição HTTP para a API pública do **ViaCEP** diretamente no servidor PHP.

Crie o arquivo `services/ViaCEPService.php`:

```php
<?php

class ViaCEPService
{
   //preparando o codigo
}
```

---

## 🗓️ Passo 3: Criando a Model e Manipulando Datas

Agora vamos criar a classe de modelo `Endereco.php`, onde aplicaremos as funções nativas de tratamento de datas do PHP.

Crie o arquivo `models/Endereco.php`:

```php
<?php
require_once __DIR__ . '/../config.php';

class Endereco
{
    private ?int $id;
    private int $usuarioId;
    private string $cep;
    private string $logradouro;
    private string $numero;
    private ?string $complemento;
    private string $bairro;
    private string $cidade;
    private string $uf;
    
    // 💬 CONCEITO 4: O tipo de dado DateTime no PHP
    // Em vez de salvar datas como simples strings (ex: "2026-09-18"), a orientação a objetos no PHP
    // oferece a classe nativa DateTime, que permite fazer cálculos, comparações e formatações com facilidade.
    private DateTime $dataCadastro;

    public function __construct(
        int $usuarioId,
        string $cep,
        string $logradouro,
        string $numero,
        ?string $complemento,
        string $bairro,
        string $cidade,
        string $uf,
        ?string $dataCadastro = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->cep = $cep;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->uf = $uf;
        
        // 💬 CONCEITO 5: Instanciando DateTime
        // Se uma string de data for fornecida, ela é convertida em DateTime.
        // Se for null, 'new DateTime()' assume automaticamente a data e a hora ATUAIS do servidor.
        $this->dataCadastro = $dataCadastro ? new DateTime($dataCadastro) : new DateTime();
    }

    public function cadastrar(): bool
    {
        global $pdo;

        $sql = "INSERT INTO enderecos (usuario_id, cep, logradouro, numero, complemento, bairro, cidade, uf, data_cadastro) 
                VALUES (:u, :cep, :log, :num, :comp, :bairro, :cidade, :uf, :data_cad)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':u' => $this->usuarioId,
            ':cep' => $this->cep,
            ':log' => $this->logradouro,
            ':num' => $this->numero,
            ':comp' => $this->complemento,
            ':bairro' => $this->bairro,
            ':cidade' => $this->cidade,
            ':uf' => $this->uf,
            
            // 💬 CONCEITO 6: Formatação de Datas com ->format()
            // O MySQL espera a data no formato padrão internacional 'Y-m-d H:i:s' (Ano-mês-dia Hora:minuto:segundo).
            ':data_cad' => $this->dataCadastro->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Retorna a data no formato legível do padrão brasileiro (Exemplo: 18/09/2026 às 14:30:00).
     */
    public function getDataCadastroFormatada(): string
    {
        // O caractere '\' escapa as letras para que não sejam interpretadas como especificadores de data.
        return $this->dataCadastro->format('d/m/Y \à\s H:i:s');
    }

    /**
     * 💬 CONCEITO 7: Operações Temporais com DateInterval
     * Para somar ou subtrair períodos (dias, meses, anos) de uma data, utilizamos a classe DateInterval.
     * O parâmetro "P7D" indica um Período (P) de 7 Dias (7D).
     */
    public function calcularEstimativaEntrega(int $dias = 7): string
    {
        // Clonamos o objeto para evitar alterar a data de cadastro original da instância
        $dataEntrega = clone $this->dataCadastro;
        
        // Adiciona o intervalo de dias à data clonada
        $dataEntrega->add(new DateInterval("P{$dias}D"));
        
        return $dataEntrega->format('d/m/Y');
    }
}
```

---

## 🖼️ Passo 4: Construindo o Formulário no PHP

Agora criaremos o formulário HTML/PHP para o usuário consultar o CEP e preencher o endereço.

Crie o arquivo `cadastro_endereco.php`:

```php
<?php
require_once __DIR__ . '/admin/produtos/functions.php';
require_once __DIR__ . '/services/ViaCEPService.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?erro=Faça+login+para+cadastrar+um+endereço");
    exit();
}

// Inicializamos as variáveis de formulário
$cep         = $_GET['cep_busca'] ?? '';
$logradouro  = '';
$bairro      = '';
$cidade      = '';
$uf          = '';
$erroCep     = '';

// 💬 CONCEITO 8: Processamento em dois estágios no servidor
// Quando o usuário envia o CEP pelo formulário de busca (GET),
// o servidor PHP intercepta a requisição, consome a API do ViaCEP e preenche os campos do formulário.
if (!empty($cep)) {
    $dadosEndereco = ViaCEPService::buscarEnderecoPorCep($cep);
    
    if ($dadosEndereco) {
        $logradouro = $dadosEndereco['logradouro'];
        $bairro     = $dadosEndereco['bairro'];
        $cidade     = $dadosEndereco['localidade'];
        $uf         = $dadosEndereco['uf'];
    } else {
        $erroCep = "CEP não encontrado ou inválido.";
    }
}

exibirCabecalho("PI3 Store - Cadastrar Endereço");
exibirNavbar();
?>

<main class="container page-cart" style="max-width: 600px; margin-top: 30px;">
    <h2>Cadastrar Endereço de Entrega</h2>

    <!-- Etapa A: Busca do CEP (Requisição GET) -->
    <form action="cadastro_endereco.php" method="GET" style="margin-bottom: 25px; background: #f8f9fa; padding: 15px; border-radius: 5px;">
        <label for="cep_busca"><strong>Buscar CEP (Consulta via API PHP):</strong></label>
        <div style="display: flex; gap: 10px; margin-top: 5px;">
            <input type="text" id="cep_busca" name="cep_busca" value="<?= htmlspecialchars($cep) ?>" placeholder="00000000" maxlength="8" required style="flex: 1; padding: 8px;">
            <button type="submit" class="btn-primary" style="padding: 8px 15px;">Buscar CEP</button>
        </div>
        <?php if ($erroCep): ?>
            <small style="color: red; margin-top: 5px; display: block;"><?= $erroCep ?></small>
        <?php endif; ?>
    </form>

    <!-- Etapa B: Salvar Endereço Completo (Requisição POST) -->
    <form action="controllers/EnderecoController.php?acao=cadastrar" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        <input type="hidden" name="cep" value="<?= htmlspecialchars($cep) ?>">

        <div>
            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro" value="<?= htmlspecialchars($logradouro) ?>" required style="width: 100%; padding: 8px;">
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" required style="width: 100%; padding: 8px;">
            </div>
            <div style="flex: 2;">
                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento" style="width: 100%; padding: 8px;">
            </div>
        </div>

        <div>
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" value="<?= htmlspecialchars($bairro) ?>" required style="width: 100%; padding: 8px;">
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 3;">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($cidade) ?>" required style="width: 100%; padding: 8px;">
            </div>
            <div style="flex: 1;">
                <label for="uf">UF:</label>
                <input type="text" id="uf" name="uf" value="<?= htmlspecialchars($uf) ?>" maxlength="2" required style="width: 100%; padding: 8px;">
            </div>
        </div>

        <button type="submit" class="btn-primary" style="padding: 10px; cursor: pointer;">Salvar Endereço</button>
    </form>
</main>

<?php exibirRodape(); ?>
```

---

## 🎮 Passo 5: Criando o Controller

Por fim, vamos receber os dados submetidos pelo formulário e persistir o novo endereço.

Crie o arquivo `controllers/EnderecoController.php`:

```php
<?php
require_once __DIR__ . '/../models/Endereco.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$acao = $_GET['acao'] ?? '';

    //verificando a ação cadastrar
}
```

---

## 📌 Resumo dos Conceitos Apresentados

| Conceito | Método / Classe | Função no Projeto |
| :--- | :--- | :--- |
| **Limpeza de Strings** | `preg_replace()` | Remove caracteres especiais e letras do CEP digitado. |
| **Requisição HTTP GET** | `file_get_contents($url)` | Consulta a API REST externa do ViaCEP no lado do servidor. |
| **Decodificação JSON** | `json_decode($json, true)` | Transforma a resposta da API (string JSON) em um Array Associativo nativo do PHP. |
| **Objeto de Data** | `new DateTime()` | Representa datas e horas de forma orientada a objetos. |
| **Formatação de Data** | `$date->format('d/m/Y')` | Converte a data para os padrões do banco de dados (`Y-m-d H:i:s`) ou exibição PT-BR (`d/m/Y`). |
| **Cálculos Temporais** | `$date->add(new DateInterval('P7D'))` | Realiza cálculos de adição de períodos temporais em objetos de data. |