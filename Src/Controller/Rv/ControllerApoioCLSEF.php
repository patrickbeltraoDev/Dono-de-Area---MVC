<?php

namespace Controller\Rv;

use Controller\Rv\ControllerInterface;
use Service\Rv\MinhaRvService;
use Service\ViewRenderer;

class ControllerApoioCLSEF
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
        $view = new ViewRenderer();
        $view->render('viewApoioCLSEF', [
            'dadosMinhaRV' => $dadosMinhaRV->executeData(),
            'dadosGraficoRV' => $dadosMinhaRV->executeGraph(),
            'treatMonth' => $dadosMinhaRV->treatMonth()
        ]);
    }
}