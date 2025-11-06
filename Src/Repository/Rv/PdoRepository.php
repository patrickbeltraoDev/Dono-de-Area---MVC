<?php

namespace Repository\Rv;
use Model\User;
use \PDO;
use \PDOException;
use Repository\Rv\PeriodoQueryTrait;

class PdoRepository
{
    use PeriodoQueryTrait;
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function consultMyRv(User $user, $mesAnterior)
    {
        try {
            $sql = "SELECT *,
                        CASE
                            WHEN UPPER(CARGO) LIKE '%SUPERVISOR%' THEN COORDENADOR_ATUAL
                            WHEN UPPER(CARGO) LIKE '%COORDENADOR%' THEN GERENTE_ATUAL
                            WHEN UPPER(CARGO) LIKE '%GESTOR%' THEN GERENTE_ATUAL
                            ELSE `LIDER IMEDIATO_ATUAL`
                        END AS HIERARQUIA_USER,
                        IF(PADRINHO = 'SIM', 'R$ 200,00', 'NÃO') AS PADRINHO
                    FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                    WHERE 
                        MES = " . $this->getPeriodoSubquery($mesAnterior) . "
                        AND NK_CHAPA = :chapa";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':chapa', $user->getChapa(), PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            return [];
        }
    }
    public function consultGraphRV(User $user, $mesAnterior)
    {
        try {

            $sql = "SELECT
                            MES, ROUND(RV, 2) AS RV
                        FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                        WHERE 
                            MES >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%Y-%m-01')
                            AND MES <= DATE_FORMAT(" . $this->getPeriodoSubquery($mesAnterior) . ", '%Y-%m-01')
                            AND NK_CHAPA = :chapa
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':chapa' => $user->getChapa()]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        } 
    }
    public function consultDataLeader(User $user, $mesAnterior)
    {
        try {
            $sql = "SELECT * 
                    FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                    WHERE 
                        MES = " . $this->getPeriodoSubquery($mesAnterior) . "
                        AND NK_CHAPA = :chapa
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':chapa', $user->getChapa(), PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Tratar erro de consulta
            echo "Erro na consulta: " . $e->getMessage();
            return [];
        }
    }
    public function consultTableLeader(User $user, $cargoAtual, $mesAnterior)
    {
        try {
            $sql = "SELECT 
                        NK_CHAPA,
                        NM_FUNCIONARIO,
                        TECNICOS,
                        TOTAL_CS,
                        PRODUTIVIDADE,
                        NIVEL_PRODUTIVIDADE,
                        RV
                    FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                    WHERE MES = " . $this->getPeriodoSubquery($mesAnterior) . "
                        AND $cargoAtual IN('{$user->getNome()}')
                        AND (SITUACAO = 'ATIVO' OR (SITUACAO <> 'ATIVO' AND COM_RV = 'SIM'))
                        AND ORIGEM = 'LIDER'
                    GROUP BY NK_CHAPA
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Tratar erro de consulta
            echo "Erro na consulta: " . $e->getMessage();
            return [];
        }
    }
    public function consultDataQuad(User $user, $cargoAtual, $mesAnterior)
    {
        try {
            $sql = "SELECT 
                    COUNT(IF(NIVEL_PRODUTIVIDADE = 'A', 1, NULL)) AS QTD_NIVEL_A,
                    SUM(IF(NIVEL_PRODUTIVIDADE = 'A', RV, 0)) AS RV_NIVEL_A,
                    COUNT(IF(NIVEL_PRODUTIVIDADE = 'B', 1, NULL)) AS QTD_NIVEL_B,
                    SUM(IF(NIVEL_PRODUTIVIDADE = 'B', RV, 0)) AS RV_NIVEL_B,
                    COUNT(IF(NIVEL_PRODUTIVIDADE = 'C', 1, NULL)) AS QTD_NIVEL_C,
                    SUM(IF(NIVEL_PRODUTIVIDADE = 'C', RV, 0)) AS RV_NIVEL_C,
                    COUNT(IF(NIVEL_PRODUTIVIDADE = 'D', 1, NULL)) AS QTD_NIVEL_D,
                    SUM(IF(NIVEL_PRODUTIVIDADE = 'D', RV, 0)) AS RV_NIVEL_D
                FROM 
                    modulo_rv.tbl_telemont_nova_rv_ftth_resultado AS a
                WHERE
                    $cargoAtual IN('{$user->getNome()}') 
                    AND MES = " . $this->getPeriodoSubquery($mesAnterior) . "
                    AND (SITUACAO = 'ATIVO' OR (SITUACAO <> 'ATIVO' AND (COM_RV = 'SIM' OR ATIV_ENCERRADAS = 'SIM')))
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Tratar erro de consulta
            echo "Erro na consulta: " . $e->getMessage();
            return [];
        }
    }
    public function consultTableFunc(User $user, $cargoAtual, $mesAnterior)
    {
        try {
            $sql = "SELECT 
                    NK_CHAPA,
                    NM_FUNCIONARIO,
                    SITUACAO,
                    TOTAL_CS,
                    PRODUTIVIDADE,
                    NIVEL_PRODUTIVIDADE,
                    TRUNCATE((INFANCIA_RESULTADO * 100), 2) AS INFANCIA_RESULTADO,
                    TRUNCATE((REPETIDA_RESULTADO * 100), 2) AS REPETIDA_RESULTADO,
                    BONUS,
                    RV
                FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                WHERE MES = " . $this->getPeriodoSubquery($mesAnterior) . "
                    AND $cargoAtual IN('{$user->getNome()}')
                    AND (SITUACAO = 'ATIVO' OR (SITUACAO <> 'ATIVO' AND (COM_RV = 'SIM' OR ATIV_ENCERRADAS = 'SIM')))
                    AND ORIGEM = 'TECNICOS'
                GROUP BY NK_CHAPA ORDER BY RV DESC
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Tratar erro de consulta
            echo "Erro na consulta: " . $e->getMessage();
            return [];
        }
    }
    public function consultFuncLeader(User $user, $cargoAtual, $mesAnterior)
    {
        try {
            $sql = "SELECT 
                        COUNT(NK_CHAPA) AS TOTAL_FUNCIONARIOS,
                        TRUNCATE(SUM(RV), 2) AS TOTAL_RV
                    FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado 
                    WHERE MES = " . $this->getPeriodoSubquery($mesAnterior) . "
                        AND $cargoAtual IN('{$user->getNome()}')
                        AND SITUACAO = 'ATIVO'
                        AND ORIGEM = 'APOIO'
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Tratar erro de consulta
            echo "Erro na consulta: " . $e->getMessage();
            return [];
        }
    }
    public function consultFuncLeaderTable(User $user, $cargoAtual, $mesAnterior)
    {
        try {
            $sql = "SELECT 
                        UF,
                        NM_FUNCIONARIO,
                        SITUACAO,
                        CARGO,
                        AREA,
                        VALOR_FINAL_OS_RET,
                        BONUS,
                        IF(ASSIDUIDADE IS NULL, '', TRUNCATE((ASSIDUIDADE * 100), 0)) AS ASSIDUIDADE,
                        RV
                    FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                    WHERE MES = " . $this->getPeriodoSubquery($mesAnterior) . "
                    AND $cargoAtual IN('{$user->getNome()}')
                    AND (SITUACAO = 'ATIVO')
                    GROUP BY NK_CHAPA ORDER BY RV DESC
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Tratar erro de consulta
            echo "Erro na consulta: " . $e->getMessage();
            return [];
        }
    }
}