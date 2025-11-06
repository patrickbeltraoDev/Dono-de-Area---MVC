<?php

namespace Service\Rv;

use Repository\Rv\PdoRepository;

class RvEquipeService
{
    private $repo;
    private $user;
    private $conn;
    private $mesAnterior;

    public function __construct($user, $conn, $mesAnterior)
    {
        $this->user = $user;
        $this->conn = $conn;
        $this->repo = new PdoRepository($conn);
        $this->mesAnterior = $mesAnterior;
    }
    public function executeDataRvEquipe()
    {
        return $this->repo->consultDataLeader($this->user, $this->mesAnterior)[0];
    }
    public function executeTableLeader()
    {
        return $this->repo->consultTableLeader($this->user, $this->getCargoAtual(), $this->mesAnterior);
    }
    public function executeDataQuad()
    {
        return $this->repo->consultDataQuad($this->user, $this->getCargoAtual(), $this->mesAnterior)[0];
    }
    public function executetableFunc()
    {
        return $this->repo->consultTableFunc($this->user, $this->getCargoAtual(), $this->mesAnterior);
    }
    public function executeFuncLeader()
    {
        return $this->repo->consultFuncLeader($this->user, $this->getCargoAtual(), $this->mesAnterior)[0];
    }
    public function executeFuncLeaderTable()
    {
        return $this->repo->consultFuncLeaderTable($this->user, $this->getCargoAtual(), $this->mesAnterior);
    }
    private function getCargoAtual()
    {
        $funcoes = [
            'COORDENADOR' => 'COORDENADOR_ATUAL',
            'GESTOR'      => 'COORDENADOR_ATUAL',
            'SUPERVISOR'  => '`LIDER IMEDIATO_ATUAL`',
            'ENCARREGADO' => '`LIDER IMEDIATO_ATUAL`',
        ];

        $funcao = strtoupper($this->user->funcaoUser());

        if (!isset($funcoes[$funcao])) {
            throw new \InvalidArgumentException("Função '{$funcao}' não suportada para consulta de equipe.");
        }

        return $funcoes[$funcao];
    }
    

}