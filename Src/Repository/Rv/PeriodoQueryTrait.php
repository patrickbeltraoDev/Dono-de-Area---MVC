<?php

namespace Repository\Rv;

trait PeriodoQueryTrait
{
    public function getPeriodoSubquery($mesAnterior = false)
    {
        $offset = $mesAnterior ? " - INTERVAL 1 MONTH" : "";
        return "(SELECT DATE_FORMAT(MAX(MES)$offset, '%Y-%m-01')
                 FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado)";
    }
}