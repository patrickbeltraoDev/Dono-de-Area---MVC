<?php

namespace Controller\Elegiveis;

use Service\ViewRenderer;
use Repository\Connection;
use Service\Elegiveis\ElegiveisService;
use Repository\Elegiveis\ElegiveisRepository;

class ControllerElegivies
{
    private $conn;
    private $dtoSection;
    public function __construct($dtoSection)
    {
        $this->conn = new Connection();
        $this->dtoSection = $dtoSection;
    }
    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    public function handle()
    {
        $view = new ViewRenderer();
        $view->render('viewElegiveis', ['nomeUser' => $this->dtoSection->getNomeUsuario()]);
    }
    public function verifyFilter()
    {
        if (ob_get_length()) ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true);

        $repo = new ElegiveisRepository($this->conn);
        $service = new ElegiveisService($input, $repo);
        $resultado = $service->executeConn();

        echo json_encode($resultado);
        exit;
    }
    public function buscarElegiveis()
    {
        if (ob_get_length()) ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true);

        $repo = new ElegiveisRepository($this->conn);
        $service = new ElegiveisService($input, $repo);
        $result = $service->buscarTabela();

        echo json_encode($result);
        exit;
    }
    public function saveElegiveis()
    {
        // Limpa qualquer output anterior
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json; charset=utf-8');

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                throw new \Exception("Dados inválidos");
            }

            $repo    = new ElegiveisRepository($this->conn);
            $service = new ElegiveisService($input, $repo);

            // Salva/Atualiza registros
            $result = $service->execSaveElegiveis();

            // Retorna JSON de sucesso
            echo json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            // Retorna JSON de erro
            echo json_encode([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }

        exit;
    }

}
