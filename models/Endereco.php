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
            
            ':data_cad' => $this->dataCadastro->format('Y-m-d H:i:s')
        ]);
    }


    public function getDataCadastroFormatada(): string
    {
        // O caractere '\' escapa as letras para que não sejam interpretadas como especificadores de data.
        return $this->dataCadastro->format('d/m/Y \à\s H:i:s');
    }

    
    public function calcularEstimativaEntrega(int $dias = 7): string
    {
     
        $dataEntrega = clone $this->dataCadastro;

        $dataEntrega->add(new DateInterval("P{$dias}D"));
        
        return $dataEntrega->format('d/m/Y');
    }
}
