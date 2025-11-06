<?php

namespace Controller\Rv;
use Service\Rv\MinhaRvService;
use Service\Rv\RvEquipeService;
use Service\ViewRenderer;
class ControllerLiderancaQualidade
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
        $view->render('viewLiderancaQualidade', [
            'dadosMinhaRV' => $dadosMinhaRV->executeData(),
            'dadosGraficoRV' => $dadosMinhaRV->executeGraph(),
            'treatMonth' => $dadosMinhaRV->treatMonth(),
            'dadosQtdEquipe' => $dadosRvEquipe->executeFuncLeader(),
            'tabelaFuncLeader' => $dadosRvEquipe->executeFuncLeaderTable()
        ]);
    }
}