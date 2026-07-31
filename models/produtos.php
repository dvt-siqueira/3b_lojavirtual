<?php
require_once __DIR__ . '/../config.php';
class Produto
{
    public $id;
    public $nome;
    public $preco;
    public $quantidade;
    public $descricao;
    public $foto; //armaxenar a foto do produto

    public function fazerUpload($arquivo)
    {
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $novoNome = md5(uniqid()) . '.' . $extensao;
        $direteorio = "../../assets/img/produtos/";

        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array(strtolower($extensao), $tiposPermitidos)) {
            throw new Exception("Tipo de arquivo não permitido");
        }
        if (move_uploaded_file($arquivo['tmp_name'], $direteorio . $novoNome)) {
            $this->foto = $novoNome;
            return true;
        } else {
            return false;
        }
    }

    public function getUrlFoto()
    {
        if ($this->foto) {
            return "../../assets/img/produtos/" . $this->foto;
        }
        return "../../assets/img/produtos/sem-foto.png"; // Imagem padrão
    }
}
