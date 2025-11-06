<?php

namespace Service\Rv;

use Model\User;
use Repository\Connection;
class ServiceController
{
    private $user;
    private $conn;
    private $mesAnterior;
    public function __construct(User $user, Connection $conn, $mesAnterior = false)
    {
        $this->user = $user;
        $this->conn = $conn;
        $this->mesAnterior = $mesAnterior;
    }
    public function execute()
    {
        $tipoCargo = $this->verifyFunction();
        $map = [
            "LIDERANCA_TECNICOS" => \Controller\Rv\ControllerLiderancaTecnicos::class,
            "APOIO_LIDERANCA_QUALIDADE" => \Controller\Rv\ControllerLiderancaQualidade::class,
            "TECNICO" => \Controller\Rv\ControllerTecnico::class,
            "APOIO_QUALIDADE" => \Controller\Rv\ControllerApoioQualidade::class,
            "APOIO_CL_SEF_OPE" => \Controller\Rv\ControllerApoioCLSEF::class
        ];

        if (!isset($map[$tipoCargo])) {
            throw new \Exception("Tipo de cargo não mapeado: $tipoCargo");
        }

        $controllerClass = $map[$tipoCargo];
        $controller = new $controllerClass($this->user, $this->conn);
        $controller->handle($this->mesAnterior);
    }
    public function verifyFunction()
    {
        $cargo = strtoupper($this->user->funcaoUser());
        $funcao = strtoupper($this->user->getFuncao());
        $cargosLideranca = ['SUPERVISOR', 'COORDENADOR', 'GERENTE', 'LIDER', 'ENCARREGADO', 'GESTOR'];
        $cargosTecnicos = ['AGENTE', 'INSTALADOR', 'AUXILIAR', 'REPARADOR', 'TECNICO', 'TRAINEE', 'QUALIFICADOR'];
        $cargos_lider_apoio_qualidade = [
            'COORDENADOR REG GESTAO QUALIDADE',
            'SUPERVISOR REG GESTAO QUALIDADE',
            'COORDENADOR REG SISTEMAS INFORMACAO'
        ];
        $cargos_lider_apoio_cl_sef = [
            'COORDENADOR CONTROLE LOCAL',
            'ENCARREGADO CONTROLE LOCAL',
            'ENCARREGADO EQUIPE I',
            'SUPERVISOR CONTROLE LOCAL'
        ];
        $cargos_apoio_qualidade_pcp_ope = [
            'ANALISTA REG PLANEJ E CONTR OPERAC SR',
            'ANALISTA REG PLANEJAMENTO E CONTROLE JR',
            'ANALISTA REG GESTAO DA QUALIDADE JR',
            'ANALISTA REG INDICADORES PL',
            'PROGRAMADOR SISTEMAS INFORMACAO JR',
            'ANALISTA REG APOIO OPERACAO JR',
            'ANALISTA REG GESTAO DA QUALIDADE PL',
            'ASSISTENTE REG GESTAO QUALIDADE',
            'PROGRAMADOR SISTEMAS INFORMACAO SR',
            'ANALISTA REG GESTAO DA QUALIDADE SR'
        ];
        $cargos_apoio_cl_sef_ope = [
            'OPERADOR SUPORTE TECNICO II',
            'OPERADOR SUPORTE TECNICO III',
            'OPERADOR SUPORTE TECNICO I',
            'OPERADOR PROCESSAMENTO COMUNICACAO DADOS',
            'AUXILIAR TECNICO PROJETOS I',
            'ASSISTENTE SUPORTE OPERACIONAL',
            'APOIO ADMINISTRATIVO',
            'ASSISTENTE REG ADMINISTRATIVO II',
            'ANALISTA REG GESTAO DA QUALIDADE JR',
            'APRENDIZ ADMINISTRATIVO - ART 429 CLT',
            'ASSISTENTE CONTROLE LOCAL',
            'ASSISTENTE REG INDICADORES',
            'ANALISTA REG INDICADORES JR',
            'ANALISTA EFICIENCIA JR'
        ];

        if (in_array($cargo, $cargosLideranca)) {
            if (in_array($funcao, $cargos_lider_apoio_qualidade)) {
                return "APOIO_LIDERANCA_QUALIDADE"; //ABRANGE OS CARGOS DE LIDERANÇA DO PCP E QUALIDADE
            } 
            if (in_array($funcao, $cargos_lider_apoio_cl_sef)) {
                return "APOIO_LIDERANCA_CL_SEF"; // ABRANGE OS CARGOS DE LIDERANÇA DO CONTROLE LOCAL E SEF
            }
            return "LIDERANCA_TECNICOS";
        } else {
            if (in_array($cargo, $cargosTecnicos)) {
                return "TECNICO";
            } 
            if (in_array($funcao, $cargos_apoio_qualidade_pcp_ope)) {
                return "APOIO_QUALIDADE"; // ABRANGE OS CARGOS DE APOIO DO PCP E QUALIDADE E XERIFE
            }
            if (in_array($funcao, $cargos_apoio_cl_sef_ope)) {
                return "APOIO_CL_SEF_OPE"; // ABRANGE OS CARGOS DE APOIO DO CONTROLE LOCAL E SEF
            }
        }
    }
}