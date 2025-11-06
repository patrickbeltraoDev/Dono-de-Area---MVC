<?php

namespace Controller\Rv;
use Service\Rv\MinhaRvService;
use Service\ViewRenderer;
use Service\Rv\RvEquipeService;
use Controller\Rv\ControllerInterface;

class ControllerLiderancaTecnicos
{
    private $user;
    private $conn;
    public function __construct($user, $conn)
    {
        $this->user = $user;
        $this->conn = $conn;
    }
    public function handle($mesAnterior)
    {
        $dadosMinhaRV = new MinhaRvService($this->user, $this->conn, $mesAnterior);
        $dadosRvEquipe = new RvEquipeService($this->user, $this->conn, $mesAnterior);

        $view = new ViewRenderer();
        $view->render('viewLiderancaTecnico', [
            'dadosMinhaRV' => $dadosMinhaRV->executeData(),
            'dadosGraficoRV' => $dadosMinhaRV->executeGraph(),
            'dadosRvEquipe' => $dadosRvEquipe->executeDataRvEquipe(),
            'tabelaRvLeader' => $dadosRvEquipe->executeTableLeader(),
            'dadosQd' => $dadosRvEquipe->executeDataQuad(),
            'tabelaFunc' => $dadosRvEquipe->executetableFunc(),
            'treatMonth' => $dadosMinhaRV->treatMonth()
        ]);
    }
}