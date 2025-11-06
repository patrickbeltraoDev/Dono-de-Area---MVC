<?php

namespace  Repository\Elegiveis;

use PDO;
use PDOException;

class ElegiveisRepository
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    /**
    * @param string $campo Valor do filtro WHERE (ex: 'UF', 'GERENTE', 'GESTOR')
    * @param string $valor Valor a ser aplicado no filtro
    * @param string $colunaRetorno Coluna que deve ser retornada (ex: 'GERENTE','GESTOR','SUPERVISOR')
    * @return array
    */
    public function conFilter($filters, $colunaRetorno)
    {
        $colunasPermitidas = ['UF', 'GERENTE', 'COORDENADOR', 'SUPERVISOR'];
        
        // segurança mínima
        if (!in_array($colunaRetorno, $colunasPermitidas)) {
            return [];
        }

        $where = [];
        $params = [];

        foreach ($filters as $coluna => $valor) {
            if (in_array($coluna, $colunasPermitidas) && $valor !== "") {
                $where[] = "$coluna = :$coluna";
                $params[":$coluna"] = $valor;
            }
        }

        if (empty($where)) return [];

        $sql = "
            SELECT $colunaRetorno
            FROM modulo_dw.vw_hierarquia_elegiveis_rv
            WHERE " . implode(" AND ", $where) . "
            GROUP BY $colunaRetorno
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function buscarTabela($filters)
    {
        $colunasPermitidas = ['UF','GERENTE','COORDENADOR','SUPERVISOR','OUTRAS_COLUNAS'];

        $where = [];
        $params = [];

        foreach ($filters as $coluna => $valor) {
            if (in_array($coluna, $colunasPermitidas)) {
                $where[] = "$coluna = :$coluna";
                $params[":$coluna"] = $valor;
            }
        }

        // calcula o primeiro dia do próximo mês
        $firstNextMonth = date('Y-m-01', strtotime('+1 month'));

        $sql = "
            SELECT 
                h.UF, 
                h.REGIONAL, 
                h.FUNCIONARIO AS NOME, 
                h.NK_CHAPA AS CHAPA, 
                h.CARGO, 
                h.`CENTRO DE CUSTO` AS CENTRO_DE_CUSTO, 
                h.SEGMENTO, 
                h.AREA,
                t.CHAPA AS JA_SALVO
            FROM modulo_dw.vw_hierarquia_elegiveis_rv h
            LEFT JOIN modulo_rv.tbl_telemont_rv_elegiveis t
                ON t.CHAPA = h.NK_CHAPA
                AND t.MES = :MES_PROXIMO
        ";

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array_merge($params, [':MES_PROXIMO' => $firstNextMonth]));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function saveElegiveisRepo($registros)
    {
        // Primeiro dia do próximo mês
        $mesReferencia = date('Y-m-01', strtotime('first day of next month'));

        foreach ($registros as $r) {

            // Se no JavaScript vier em array (UF múltipla), transforma pra string
            $uf = is_array($r['UF']) ? implode(',', $r['UF']) : $r['UF'];

            // =========================
            // EDITAR (UPDATE)
            // =========================
            if (!empty($r['JA_CADASTRADO']) && $r['JA_CADASTRADO'] == 1) {

                $sql = "
                    UPDATE modulo_rv.tbl_telemont_rv_elegiveis
                    SET 
                        SEGMENTO  = :SEGMENTO,
                        NOME      = :NOME,
                        AREA      = :AREA,
                        REGIONAIS = :REGIONAIS,
                        UFs       = :UFS,
                        EIXO      = :EIXO,
                        ELEGIVEL  = :ELEGIVEL,
                        RESPONSAVEL_VALIDACAO  = :NOME_USER
                    WHERE CHAPA = :CHAPA
                    AND MES = :MES
                ";

                $stmt = $this->conn->prepare($sql);

                $stmt->execute([
                    ':SEGMENTO'  => $r['SEGMENTO'],
                    ':NOME'      => $r['NOME'],
                    ':AREA'      => $r['AREA'],
                    ':REGIONAIS' => $r['REGIONAL'],
                    ':UFS'       => $uf,
                    ':EIXO'      => $r['EIXO'],
                    ':ELEGIVEL'  => $r['ELEGIVEL'],
                    ':CHAPA'     => $r['CHAPA'],
                    ':MES'       => $mesReferencia,
                    ':NOME_USER' => $r['RESPONSAVEL_VALIDACAO'],
                ]);

                continue;
            }

            // =========================
            // SALVAR (INSERT)
            // =========================

            $sql = "
                INSERT INTO modulo_rv.tbl_telemont_rv_elegiveis (
                    MES, SEGMENTO, CHAPA, NOME, AREA, REGIONAIS, UFs, EIXO, ELEGIVEL, RESPONSAVEL_VALIDACAO
                ) VALUES (
                    :MES, :SEGMENTO, :CHAPA, :NOME, :AREA, :REGIONAIS, :UFS, :EIXO, :ELEGIVEL, :NOME_USER
                )
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':MES'       => $mesReferencia,
                ':SEGMENTO'  => $r['SEGMENTO'],
                ':CHAPA'     => $r['CHAPA'],
                ':NOME'      => $r['NOME'],
                ':AREA'      => $r['AREA'],
                ':REGIONAIS' => $r['REGIONAL'],
                ':UFS'       => $uf,
                ':EIXO'      => $r['EIXO'],
                ':ELEGIVEL'  => $r['ELEGIVEL'],
                ':NOME_USER'  => $r['NOME_USER']
            ]);
        }

        return ['ok' => true];
    }


    


}