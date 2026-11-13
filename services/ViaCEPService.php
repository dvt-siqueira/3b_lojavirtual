<?php

class ViaCEPService
{
   public static function buscarEnderecoPorCep(string $cep): ?array
   {
        $cepLimpo = preg_replace('/[^0-9]/','',$cep);
        if (strlen($cepLimpo)!==8){
            return null;
        }
        $url = "https://viacep.com.br/ws/{$cepLimpo}/json/";
        $resposta = @file_get_contents($url);

        if($resposta===false){
            return null;
        }
        $dados = json_decode($resposta,true);
        if (isset($dados['erro'])&& $dados['erro']===true){
            return null;
        }
        return $dados;
   }
}
