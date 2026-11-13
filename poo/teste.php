<?php
class Validador {
    public static function validarEmail(string $email): bool {
        // Verifica se o e-mail é válido usando filtro do PHP
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validarSenha(string $senha): bool {
        // Verifica se a senha possui no mínimo 8 caracteres
        return strlen($senha) >= 8;
    }

    public static function validarCampo(string $campo): bool {
        // Verifica se o campo não está vazio
        return !empty($campo);
    }
}

$email = "admin@exemplo.com";
$senha = "senha123";
$campo = "0";

if (Validador::validarEmail($email)) {
    echo "E-mail é válido.<br>";
} else {
    echo "E-mail é inválido.<br>";
}

if (Validador::validarSenha($senha)) {
    echo "Senha é válida.<br>";
} else {
    echo "Senha é inválida.<br>";
}

if (Validador::validarCampo($campo)) {
    echo "Campo é válido.<br>";
} else {
    echo "Campo é inválido.<br>";
}
?>