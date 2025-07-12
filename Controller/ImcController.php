<?php

namespace Controller;

use Model\Imcs;

use Exception;

class ImcController{
    
    private $imcsModel;

    public function __construct(){
        $this -> imcsModel = new Imcs();
    }

    // CALCULO E CLASSIFICAÇÃO
    public function calculateImc($weight, $height){
        try{
            /**
             * $result = [
             *  "imc": 22.82, 
             *  "BMIrange": "Sobrepeso"
             * ];
             */
            $result = [];

            if(isset($weight) and isset($height)){
                if($weight > 0 and $height > 0){
                    // ROUND é igual ao toFixed(), ou seja, defini a quantidade de caracteres depois da vírgula
                    // e arredonda.
                    $imc = round($weight / ($height * $height), 2);
                    // O array $result vai armazenar o cálculo que a variável acima tá fazendo
                    $result['imc'] = $imc;

                    $result["BMIrange"] = match (true) {
                        $imc <18.5 => "Baixo Peso",
                        $imc >= 18,5 and $imc < 25 => "Peso Normal",
                        $imc >= 25 and $imc < 30 => "Sobrepeso",
                        $imc >= 30 and $imc < 35 => "Obesidade Grau I",
                        $imc >= 35 and $imc < 40 => "Obesidade Grau II",
                        default => "Obesidade Grau III" 
                    };
                } else {
                    $result["BMIrange"] = "O peso e a altura devem conter valores positivos.";
                }
                } else {
                $result["BMIrange"] = "Por favor, informe o peso e a altura para obter o IMC.";
                }
            
                return $result;
        
        } catch (Exception $error){
            echo "Erro ao calcular IMC: ". $error->getMessage();
            return false;
        }
    }

    // SALVAR IMC NA TABELA 'imcs'
    public function saveIMC($weight, $height, $IMCresult){
        try{
            return $this -> imcsModel -> createImc($weight, $height, $IMCresult);
        }catch (Exception $error){
            echo "". $error->getMessage();
            return false;
        }
    }
}
?>