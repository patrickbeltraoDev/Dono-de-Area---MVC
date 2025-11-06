<?php

namespace Service\Rv;
use Repository\Connection;
use Repository\Rv\PdoRepository;
use DateTime;

class MinhaRvService
{
    private $user;
    private $conn;
    private $repo;
    private $mesAnterior;
    public function __construct($user, $conn, $mesAnterior)
    {
        $this->user = $user;
        $this->conn = $conn;
        $this->repo = new PdoRepository($this->conn);
        $this->mesAnterior = $mesAnterior;
    }
    public function executeData()
    {
        return $this->repo->consultMyRv($this->user, $this->mesAnterior)[0];
    }
    public function treatMonth()
    {
        setlocale(LC_TIME, 'Portuguese_Brazil.1252');
        $mesEmAberto = $this->executeData()['MES'];
        $data = new DateTime($mesEmAberto);
        $mesAtual =  strftime('%B/%Y', $data->getTimestamp());

        $mesAnterior = strftime('%B', strtotime('-1 month', strtotime($mesEmAberto)));

        if (!$this->mesAnterior == false || !$this->mesAnterior == '') {
            $lgdMesAnterior = "Historico RV";
        } else {
            $lgdMesAnterior = "Historico RV - (O Mês de " . $mesAnterior . " esta em apuração)";
        }

        // if (!$this->mesAnterior) ? $mesAnterior = "Historico RV" : $mesAnterior = "Historico RV - (O Mês de " . $mesAnterior . " esta em apuração)";
        return [
            'mesAtual' => $mesAtual,
            'mesAnterior' => $lgdMesAnterior
        ];
    }
    public function executeGraph()
    {
        $dadosGraph = $this->repo->consultGraphRV($this->user, $this->mesAnterior);

        $array_rv             = [];
        $array_legendas_graf  = [];

        $meses = [
            1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
            5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
        ];

        foreach ($dadosGraph as $res) {

            $array_rv[]  = $res['RV'];            
            $lgds_grafico = new DateTime($res['MES']);
            $lgds_grafico = $lgds_grafico->format('n');
            $lgds_meses   = $meses[$lgds_grafico];

            $array_legendas_graf[] = $lgds_meses;
        }

        return [
            'histRV' => $array_rv,
            'legends_graf' => $array_legendas_graf
        ];
    }

}