<?php

/**
 * Percentual a ser aplicado ao mês composto
 * Valor em %
 */
$percentual_mes = 0.8;

/**
 * Atribui o valor da variavel $percentual_mes a uma constante
 */
define("PERCENTUAL_MES", $percentual_mes);

/**
 * Valor a ser depositado mês a mês
 */
$deposito_mes = 4320;

/**
 * Atribui o valor da variavel $deposito_mes a uma constante
 */
define("DEPOSITO_MES", $deposito_mes);

/**
 * Quantidade de meses da aplicação
 */
$meses = 24;

/**
 * Dados da aplicação
 */
$data = run($meses);

echo '<h2>Simulador</h2>';
echo 'Periodo de '.$meses.' meses';
echo '<br><br>';
echo 'Percentual ao mes '.$data['percentual'].'% composto';
echo '<br><br>';
echo 'Valor depositado ao mes R$ '. number_format($data['deposito'], 2, ',', '.');
echo '<br><br>';
echo 'Montante acumulado R$ '. number_format($data['montante'], 2, ',', '.');
echo '<br><br>';
echo 'Rendimento ao mes R$ '. number_format($data['rendimento'], 2, ',', '.');

/**
 * @param Int $perido periodo em meses
 * @param Int $percentual percentual a ser aplicado ao mes
 * @param Float $deposito valor a ser depositado todo mes
 * @return Array dados da aplicação
 */
function run($perido, $percentual = PERCENTUAL_MES, $deposito = DEPOSITO_MES)
{

    $calculadora = new Calculadora();

    $data['percentual'] = $percentual;

    $data['montante'] = $deposito;

    $data['deposito'] = $deposito;

    $data['mes'] = array( 0 => $deposito );

    for ($i=1; $i <= $perido; $i++) { 
        
        $data['montante'] =  $calculadora->montanteProximoMes(
            $data['montante'],
            $percentual,
            $deposito
        );

        array_push($data['mes'], $data['montante']);
    }

    $data['rendimento'] = $calculadora->rendimentoMes($data['montante'], $percentual);

    return $data;
}

class Calculadora{

    public function arredondaValor($valor, $precisao = 2){
        return round($valor, $precisao);
    }

    public function rendimentoMes($montante, $percentual)
    {
        $percentual = $percentual/100;

        $valor = $montante * $percentual;

        return $this->arredondaValor($valor);
    }

    public function montanteProximoMes($corrente, $percentual, $deposito){

        $percentual = $percentual/100;

        $val_percentual = $corrente * $percentual;

        $val_percentual = $this->arredondaValor($val_percentual);

        $valor = $corrente + $val_percentual + $deposito;

        return $this->arredondaValor($valor);
    }

}
