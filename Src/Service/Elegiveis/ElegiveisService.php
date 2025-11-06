<?php

namespace Service\Elegiveis;

class ElegiveisService
{
    private $dataForm;
    private $repo;
    public function __construct($dataForm, $repo)
    {
        $this->dataForm = $dataForm;
        $this->repo = $repo;
    }
    public function executeConn()
    {
        $f = $this->dataForm;

        // 3) UF + GERENTE + COORDENADOR → SUPERVISOR
        if (!empty($f['uf']) && !empty($f['gerente']) && !empty($f['coordenador'])) {
            return $this->repo->conFilter([
                'UF'          => $f['uf'],
                'COORDENADOR' => $f['coordenador']
            ], 'SUPERVISOR');
        }

        // 2) UF + GERENTE → COORDENADOR
        if (!empty($f['uf']) && !empty($f['gerente'])) {
            return $this->repo->conFilter([
                'UF'      => $f['uf'],
                'GERENTE' => $f['gerente']
            ], 'COORDENADOR');
        }

        // 1) UF → GERENTE
        if (!empty($f['uf'])) {
            return $this->repo->conFilter(['UF' => $f['uf']], 'GERENTE');
        }

        return [];
    }
    public function buscarTabela()
    {
        $filters = [];

        if (!empty($this->dataForm['uf'])) $filters['UF'] = $this->dataForm['uf'];
        if (!empty($this->dataForm['gerente'])) $filters['GERENTE'] = $this->dataForm['gerente'];
        if (!empty($this->dataForm['coordenador'])) $filters['COORDENADOR'] = $this->dataForm['coordenador'];
        if (!empty($this->dataForm['supervisor'])) $filters['SUPERVISOR'] = $this->dataForm['supervisor'];

        if (!$filters) return []; // nenhum filtro válido

        return $this->repo->buscarTabela($filters);
    }
    public function execSaveElegiveis()
    {
        return $this->repo->saveElegiveisRepo($this->dataForm);
    }
   


}

