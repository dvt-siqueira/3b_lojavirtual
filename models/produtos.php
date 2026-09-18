<?php

require_once __DIR__ . '/../config.php';

class Produto 
{
    private ?int $id;
    private string $nome;
    private float $preco;
    private string $descricao;
    private string $imagem;

    public function __construct(
        string $nome = '', 
        float $preco = 0.0, 
        string $descricao = '', 
        string $imagem = '', 
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->descricao = $descricao;
        $this->imagem = $imagem;
    }

    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getPreco(): float { return $this->preco; }
    public function getDescricao(): string { return $this->descricao; }
    public function getImagem(): string { return $this->imagem; }

    public static function buscarPorId(int $id): ?Produto 
    {
        $db = Conexao::getConexao();
        $stmt = $db->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dados) return null;

        return new Produto(
            $dados['nome'],
            (float)$dados['preco'],
            $dados['descricao'] ?? '',
            $dados['imagem'] ?? 'default.png',
            (int)$dados['id']
        );
    }

    public static function listarTodos(): array 
    {
        $db = Conexao::getConexao();
        $stmt = $db->query("SELECT * FROM produtos ORDER BY id DESC");
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produtos = [];
        foreach ($registros as $dados) {
            $produtos[] = new Produto(
                $dados['nome'],
                (float)$dados['preco'],
                $dados['descricao'] ?? '',
                $dados['imagem'] ?? 'default.png',
                (int)$dados['id']
            );
        }
        return $produtos;
    }


    public function fazerUpload($arquivo)
    {
        // 1. Definimos o destino e geramos um nome único usando md5 e uniqid
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $novoNome = md5(uniqid()) . "." . $extensao;

        // Importante: a barra / no final garante que o arquivo vai para dentro do diretório
        $diretorio = "../../assets/img/produtos/";
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array(strtolower($extensao), $tiposPermitidos)) {
            return false; // Tipo de arquivo não permitido
        }

        // 3. Movemos o arquivo da pasta temporária do PHP para a pasta final do servidor
        if (move_uploaded_file($arquivo['tmp_name'], $diretorio . $novoNome)) {
            $this->imagem = $novoNome; // Salva o nome gerado no atributo do objeto
            return true;
        }
        return false;
    }
}
